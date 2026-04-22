<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    // ─── Show Profile Form ────────────────────────────────────────
    public function edit()
    {
        // studentProfile() is defined on User — hasOne(StudentProfile::class)
        $profile = Auth::user()->studentProfile;

        return view('CounselConnect.student.profile.profile', compact('profile'));
    }

    // ─── Update Profile ───────────────────────────────────────────
    public function update(Request $request)
{
    $user = Auth::user();

    $data = $request->validate([
        'name'            => ['required', 'string', 'max:255'],
        'bio'             => ['nullable', 'string', 'max:2000'],
        'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        'remove_photo'    => ['nullable', 'boolean'],
    ]);

    $user->update(['name' => $data['name']]);

    // ← replace the old make() line with this
    $profile = StudentProfile::firstOrNew(['user_id' => $user->id]);

    if ($request->boolean('remove_photo') && $profile->profile_picture) {
        Storage::disk('public')->delete($profile->profile_picture);
        $profile->profile_picture = null;
    }

    if ($request->hasFile('profile_picture')) {
        if ($profile->profile_picture) {
            Storage::disk('public')->delete($profile->profile_picture);
        }
        $profile->profile_picture = $request->file('profile_picture')
            ->store('profile-pictures/students', 'public');
    }

    // ← and use direct assignment instead of fill()
    $profile->user_id = $user->id;
    $profile->bio     = $data['bio'] ?? null;
    $profile->save();

    return redirect()->route('student.profile.edit')
        ->with('success', 'Profile updated successfully.');
}
}