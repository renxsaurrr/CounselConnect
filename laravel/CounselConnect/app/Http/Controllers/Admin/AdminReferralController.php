<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminReferralController extends Controller
{
    // ─── List Referrals ──────────────────────────────────────────
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'newest');

        $query = Referral::with([
            'referredBy.counselorProfile',
            'referredTo.counselorProfile',
            'student.studentProfile',
        ]);

        // ── Sorting ──
        match ($sort) {
            'oldest'       => $query->oldest(),
            'pending'      => $query->orderByRaw("FIELD(status, 'pending', 'acknowledged')"),
            'acknowledged' => $query->orderByRaw("FIELD(status, 'acknowledged', 'pending')"),
            default        => $query->latest(),
        };

        $referrals = $query->paginate(15)->withQueryString();

        return view('CounselConnect.admin.referrals.index', compact('referrals', 'sort'));
    }

    // ─── Show Create Form ────────────────────────────────────────
    // The create form is embedded as a modal in the index page.
    public function create()
    {
        return redirect()->route('admin.referrals.index');
    }

    // ─── Store Referral ──────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'referred_by' => ['required', Rule::exists('users', 'id')->where('role', 'counselor')],
            'referred_to' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'counselor'),
                // Prevent someone from being referred to themselves
                Rule::notIn([$request->input('referred_by')]),
            ],
            'student_id'  => ['required', 'exists:users,id'],
            'reason'      => ['required', 'string'],
            'type'        => ['required', 'in:internal,external'],
            'status'      => ['required', 'in:pending,acknowledged'],
        ], [
            'referred_to.not_in' => 'The person referred to cannot be the same as the person referring.',
        ]);

        Referral::create($data);

        return redirect()->route('admin.referrals.index')
            ->with('success', 'Referral created successfully.');
    }

    // ─── Show Single Referral ────────────────────────────────────
    public function show(Referral $referral)
    {
        $referral->load([
            'student.studentProfile',
            'referredBy.counselorProfile',
            'referredTo.counselorProfile',
        ]);

        return view('CounselConnect.admin.referrals.show', compact('referral'));
    }

    // ─── Show Edit Form ──────────────────────────────────────────
    public function edit(Referral $referral)
    {
        $referral->load([
            'student.studentProfile',
            'referredBy.counselorProfile',
            'referredTo.counselorProfile',
        ]);
        $counselors = User::where('role', 'counselor')->orderBy('name')->get();
        $students   = User::where('role', 'student')->orderBy('name')->get();

        return view('CounselConnect.admin.referrals.edit', compact('referral', 'counselors', 'students'));
    }

    // ─── Update Referral ─────────────────────────────────────────
    public function update(Request $request, Referral $referral)
    {
        $data = $request->validate([
            'referred_by' => ['required', Rule::exists('users', 'id')->where('role', 'counselor')],
            'referred_to' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'counselor'),
                // Prevent someone from being referred to themselves
                Rule::notIn([$request->input('referred_by')]),
            ],
            'student_id'  => ['required', 'exists:users,id'],
            'reason'      => ['required', 'string'],
            'type'        => ['required', 'in:internal,external'],
            'status'      => ['required', 'in:pending,acknowledged'],
        ], [
            'referred_to.not_in' => 'The person referred to cannot be the same as the person referring.',
        ]);

        $referral->update($data);

        return redirect()->route('admin.referrals.show', $referral)
            ->with('success', 'Referral updated successfully.');
    }

    // ─── Delete Referral ─────────────────────────────────────────
    public function destroy(Referral $referral)
    {
        $referral->delete();

        return redirect()->route('admin.referrals.index')
            ->with('success', 'Referral deleted.');
    }
}