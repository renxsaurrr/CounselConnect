<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionRecord;
use Illuminate\Http\Request;

class AdminSessionController extends Controller
{
    // ─── List All Session Records ────────────────────────────────
    public function index(Request $request)
    {
        $query = SessionRecord::with(['student', 'counselor', 'appointment'])
            ->latest();

        // Date filter tabs
        if ($request->filled('filter')) {
            $query->when($request->filter === 'today', fn ($q) =>
                $q->whereDate('created_at', today())
            )->when($request->filter === 'week', fn ($q) =>
                $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            )->when($request->filter === 'month', fn ($q) =>
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year)
            );
        }

        // Search by student name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn ($q) =>
                $q->where('name', 'like', "%{$search}%")
            );
        }

        $sessions = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total'        => SessionRecord::count(),
            'follow_up'    => SessionRecord::where('follow_up_needed', true)->count(),
            'this_week'    => SessionRecord::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('CounselConnect.admin.sessions.index', compact('sessions', 'stats'));
    }

    // ─── Show Single Session Record ──────────────────────────────
    public function show(SessionRecord $session)
    {
        $session->load(['student.studentProfile', 'counselor.counselorProfile', 'appointment']);

        return view('CounselConnect.admin.sessions.show', compact('session'));
    }
}