<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\CounselorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CounselorProfileController extends Controller
{
    // ─── Show Edit Form ──────────────────────────────────────────
    public function edit()
    {
        $profile = Auth::user()->counselorProfile
            ?? new CounselorProfile(['user_id' => Auth::id()]);

        return view('CounselConnect.counselor.profile.edit', compact('profile'));
    }

    // ─── Update Profile ──────────────────────────────────────────
    public function update(Request $request)
    {
        $data = $request->validate([
            'specialization'   => ['nullable', 'string', 'max:255'],
            'office_location'  => ['nullable', 'string', 'max:255'],
            'contact_number'   => ['nullable', 'string', 'max:255'],
            'bio'              => ['nullable', 'string'],
            'profile_picture'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // ── Handle profile picture upload ──
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            $existing = Auth::user()->counselorProfile?->profile_picture;
            if ($existing && Storage::disk('public')->exists($existing)) {
                Storage::disk('public')->delete($existing);
            }

            $data['profile_picture'] = $request->file('profile_picture')
                ->store('counselor_profiles', 'public');
        } else {
            // Don't overwrite existing picture if none uploaded
            unset($data['profile_picture']);
        }

        // ── Upsert: create profile if it doesn't exist yet ──
        CounselorProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return redirect()->route('counselor.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}