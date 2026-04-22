<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // ─── Show Public Login ────────────────────────────────────────
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('CounselConnect.index');
    }

    // ─── Handle Public Login (student + counselor only) ───────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $user = User::where('email', $credentials['email'])->first();

        // Block admin from public login
        if ($user && $user->role === 'admin') {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email')
              ->with('modal', 'login');
        }

        // Block inactive accounts
        if ($user && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Contact the administrator.',
            ])->onlyInput('email')
              ->with('modal', 'login');
        }

        // Block Google-only accounts from password login
        if ($user && is_null($user->password)) {
            return back()->withErrors([
                'email' => 'This account uses Google Sign-In. Please use the "Continue with Google" button.',
            ])->onlyInput('email')
              ->with('modal', 'login');
        }

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email')
              ->with('modal', 'login');
        }

        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user());
    }

    // ─── Redirect to Google ───────────────────────────────────────
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // ─── Handle Google Callback ───────────────────────────────────
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('modal', 'login')
                ->withErrors(['email' => 'Google sign-in failed. Please try again.']);
        }

        // Find existing user by google_id first, then fall back to email
        $user = User::where('google_id', $googleUser->getId())->first()
             ?? User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Block admin accounts from Google login
            if ($user->role === 'admin') {
                return redirect()->route('home')
                    ->with('modal', 'login')
                    ->withErrors(['email' => 'Admin accounts cannot use Google Sign-In.']);
            }

            // Block inactive accounts
            if (!$user->is_active) {
                return redirect()->route('home')
                    ->with('modal', 'login')
                    ->withErrors(['email' => 'Your account has been deactivated. Contact the administrator.']);
            }

            // Link google_id if this user signed up manually before
            if (is_null($user->google_id)) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            Auth::login($user, true);
            request()->session()->regenerate();

            return $this->redirectByRole($user);
        }

        // ── New user: they need to complete their profile ──────────
        // Store Google data in session temporarily
        session([
            'google_user' => [
                'google_id' => $googleUser->getId(),
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
            ],
        ]);

        return redirect()->route('google.complete-profile');
    }

    // ─── Show Complete Profile Form (after Google sign-up) ────────
    public function showCompleteProfile()
    {
        // If no pending Google user in session, redirect away
        if (!session('google_user')) {
            return redirect()->route('home')->with('modal', 'login');
        }

        return view('CounselConnect.auth.complete-profile', [
            'google_name'  => session('google_user.name'),
            'google_email' => session('google_user.email'),
        ]);
    }

    // ─── Handle Complete Profile Submission ───────────────────────
    public function completeProfile(Request $request)
    {
        if (!session('google_user')) {
            return redirect()->route('home')->with('modal', 'login');
        }

        $validator = Validator::make($request->all(), [
            'student_id' => ['required', 'string', 'unique:student_profiles,student_id'],
            'department' => ['nullable', 'string', 'max:255'],
            'year_level' => ['nullable', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $googleData = session('google_user');

        $user = User::create([
            'name'      => $googleData['name'],
            'email'     => $googleData['email'],
            'password' => $request->password, 
            'google_id' => $googleData['google_id'],
            'role'      => 'student',
            'is_active' => true,
        ]);

        StudentProfile::create([
            'user_id'    => $user->id,
            'student_id' => $request->student_id,
            'department' => $request->department ?? null,
            'year_level' => $request->year_level ?? null,
        ]);

        // Clear the temporary Google session data
        session()->forget('google_user');

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('student.dashboard');
    }

    // ─── Show Admin Login ─────────────────────────────────────────
    public function showAdminLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        return view('CounselConnect.auth.admin-login');
    }

    // ─── Handle Admin Login ───────────────────────────────────────
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || $user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'This admin account has been deactivated.',
            ])->onlyInput('email');
        }

        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    // ─── Show Register ────────────────────────────────────────────
    public function showRegister()
    {
        return view('CounselConnect.index');
    }

    // ─── Handle Registration (student only, public) ───────────────
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'student_id' => ['required', 'string', 'unique:student_profiles,student_id'],
            'department' => ['nullable', 'string', 'max:255'],
            'year_level' => ['nullable', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'register');
        }

        $data = $validator->validated();

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => 'student',
            'is_active' => true,
        ]);

        StudentProfile::create([
            'user_id'    => $user->id,
            'student_id' => $data['student_id'],
            'department' => $data['department'] ?? null,
            'year_level' => $data['year_level'] ?? null,
        ]);

        return redirect()->route('home')
            ->with('modal', 'login');
    }

    // ─── Logout ───────────────────────────────────────────────────
    public function logout(Request $request)
    {
        $role = Auth::user()->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $role === 'admin'
            ? redirect()->route('admin.login')
            : redirect()->route('login');
    }

    // ─── Redirect Helper ──────────────────────────────────────────
    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'counselor' => redirect()->route('counselor.dashboard'),
            'student'   => redirect()->route('student.dashboard'),
            default     => redirect('/'),
        };
    }
}