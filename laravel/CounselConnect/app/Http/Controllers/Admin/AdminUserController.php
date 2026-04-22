<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\CounselorProfile;
use App\Models\AdminProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // ─── List All Users ──────────────────────────────────────────
    public function index(Request $request)
    {
        $users = User::with(['studentProfile', 'counselorProfile'])
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q->where(fn($inner) => $inner
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
            ))
            ->when($request->sort === 'oldest',    fn($q) => $q->oldest())
            ->when($request->sort === 'name_asc',  fn($q) => $q->orderBy('name', 'asc'))
            ->when($request->sort === 'name_desc', fn($q) => $q->orderBy('name', 'desc'))
            ->when(!in_array($request->sort, ['oldest', 'name_asc', 'name_desc']), fn($q) => $q->latest())
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'      => User::count(),
            'active'     => User::where('is_active', true)->count(),
            'counselors' => User::where('role', 'counselor')->count(),
            'students'   => User::where('role', 'student')->count(),
        ];

        return view('CounselConnect.admin.users.index', compact('users', 'stats'));
    }

    // ─── Show Create Form ────────────────────────────────────────
    public function create()
    {
        return view('CounselConnect.admin.users.create');
    }

    // ─── Store New User ──────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:users,email'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'role'            => ['required', 'in:student,counselor,admin'],
            'student_id'      => ['required_if:role,student', 'nullable', 'unique:student_profiles,student_id'],
            'department'      => ['nullable', 'string', 'max:255'],
            'year_level'      => ['nullable', 'string', 'max:50'],
            'specialization'  => ['nullable', 'string', 'max:255'],
            'office_location' => ['nullable', 'string', 'max:255'],
            'contact_number'  => ['nullable', 'string', 'max:20'],
        ]);

        // ✅ is_active must be explicitly true — DB default is 0/null
        // and EnsureUserIsActive will immediately kick out inactive users
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => $data['role'],
            'is_active' => true,
        ]);

        match ($user->role) {
            'student'   => StudentProfile::create([
                'user_id'    => $user->id,
                'student_id' => $data['student_id'],
                'department' => $data['department'] ?? null,
                'year_level' => $data['year_level'] ?? null,
            ]),
            'counselor' => CounselorProfile::create([
                'user_id'         => $user->id,
                'specialization'  => $data['specialization'] ?? null,
                'office_location' => $data['office_location'] ?? null,
                'contact_number'  => $data['contact_number'] ?? null,
            ]),
            'admin'     => AdminProfile::create(['user_id' => $user->id]),
            default     => null,
        };

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    // ─── Show Single User ────────────────────────────────────────
    public function show(User $user)
    {
        $user->load([
            'studentProfile',
            'counselorProfile',
            'adminProfile',
            'appointmentsAsStudent.counselor',
            'appointmentsAsCounselor.student',
            'sessionRecordsAsStudent',
            'sessionRecordsAsCounselor',
        ]);

        return view('CounselConnect.admin.users.show', compact('user'));
    }

    // ─── Show Edit Form ──────────────────────────────────────────
    public function edit(User $user)
    {
        $user->load(['studentProfile', 'counselorProfile', 'adminProfile']);

        return view('CounselConnect.admin.users.edit', compact('user'));
    }

    // ─── Update User ─────────────────────────────────────────────
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:users,email,' . $user->id],
            'is_active'       => ['boolean'],
            'department'      => ['nullable', 'string', 'max:255'],
            'year_level'      => ['nullable', 'string', 'max:50'],
            'specialization'  => ['nullable', 'string', 'max:255'],
            'office_location' => ['nullable', 'string', 'max:255'],
            'contact_number'  => ['nullable', 'string', 'max:20'],
            'bio'             => ['nullable', 'string'],
        ]);

        $user->update([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'is_active' => $data['is_active'] ?? $user->is_active,
        ]);

        match ($user->role) {
            'student'   => $user->studentProfile?->update([
                'department' => $data['department'] ?? null,
                'year_level' => $data['year_level'] ?? null,
                'bio'        => $data['bio'] ?? null,
            ]),
            'counselor' => $user->counselorProfile?->update([
                'specialization'  => $data['specialization'] ?? null,
                'office_location' => $data['office_location'] ?? null,
                'contact_number'  => $data['contact_number'] ?? null,
                'bio'             => $data['bio'] ?? null,
            ]),
            default => null,
        };

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    // ─── Deactivate / Delete User ────────────────────────────────
    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User has been deactivated.');
    }
}