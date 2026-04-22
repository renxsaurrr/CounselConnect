<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselorReferralController extends Controller
{
    // ─── List Referrals ──────────────────────────────────────────
    public function index(Request $request)
    {
        $sent = Referral::where('referred_by', Auth::id())
            ->with(['referredTo', 'student.studentProfile'])
            ->latest()
            ->get();

        $received = Referral::where('referred_to', Auth::id())
            ->with(['referredBy', 'student.studentProfile'])
            ->latest()
            ->get();

        return view('CounselConnect.counselor.referrals.index', compact('sent', 'received'));
    }

    // ─── Show Create Form ────────────────────────────────────────
    public function create()
    {
        $students   = User::where('role', 'student')->with('studentProfile')->get();
        $counselors = User::where('role', 'counselor')
            ->where('id', '!=', Auth::id())
            ->with('counselorProfile')
            ->get();

        return view('CounselConnect.counselor.referrals.create', compact('students', 'counselors'));
    }

    // ─── Store Referral ──────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'  => ['required', 'exists:users,id'],
            'referred_to' => ['required', 'exists:users,id', 'different:referred_by'],
            'reason'      => ['required', 'string'],
            'type'        => ['required', 'in:internal,external'],
        ]);

        Referral::create([
            ...$data,
            'referred_by' => Auth::id(),
            'status'      => 'pending',
        ]);

        return redirect()->route('counselor.referrals.index')
            ->with('success', 'Referral submitted successfully.');
    }

    // ─── Show Single Referral ────────────────────────────────────
    public function show(Referral $referral)
    {
        $this->authorizeReferral($referral);

        $referral->load(['referredBy.counselorProfile', 'referredTo.counselorProfile', 'student.studentProfile']);

        return view('CounselConnect.counselor.referrals.show', compact('referral'));
    }

    // ─── Acknowledge a Received Referral ─────────────────────────
    public function acknowledge(Referral $referral)
    {
        abort_if($referral->referred_to !== Auth::id(), 403);
        abort_if(! $referral->isPending(), 422, 'Referral already acknowledged.');

        $referral->update(['status' => 'acknowledged']);

        return redirect()->route('counselor.referrals.show', $referral)
            ->with('success', 'Referral acknowledged.');
    }

    // Referrals are not editable or deletable once submitted
    public function edit(Referral $referral)   { abort(404); }
    public function update(Referral $referral) { abort(404); }
    public function destroy(Referral $referral){ abort(404); }

    // ─── Guard: Sender or Receiver Only ─────────────────────────
    private function authorizeReferral(Referral $referral): void
    {
        abort_if(
            $referral->referred_by !== Auth::id() && $referral->referred_to !== Auth::id(),
            403
        );
    }
}