<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReferralController extends Controller
{
    // ─── List Referrals ──────────────────────────────────────────
    public function index(Request $request)
    {
        $type = $request->query('type'); // 'internal', 'external', or null (all)

        $referrals = Referral::where('student_id', Auth::id())
            ->when(in_array($type, ['internal', 'external']), fn ($q) => $q->where('type', $type))
            ->with(['referredBy.counselorProfile', 'referredTo.counselorProfile'])
            ->latest()
            ->paginate(10)
            ->withQueryString(); // keeps ?type= in pagination links

        return view('CounselConnect.student.referrals.index', compact('referrals'));
    }

    // ─── Show Single Referral ────────────────────────────────────
    public function show(Referral $referral)
    {
        abort_if($referral->student_id !== Auth::id(), 403);

        $referral->load(['referredBy.counselorProfile', 'referredTo.counselorProfile']);

        return view('CounselConnect.student.referrals.show', compact('referral'));
    }

    // Students can only view referrals — not create, edit, or delete them
    public function create()         { abort(404); }
    public function store()          { abort(404); }
    public function edit()           { abort(404); }
    public function update()         { abort(404); }
    public function destroy()        { abort(404); }
}