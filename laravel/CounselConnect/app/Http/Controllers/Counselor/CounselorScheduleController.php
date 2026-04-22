<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\CounselorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselorScheduleController extends Controller
{
    // ─── List Schedules ──────────────────────────────────────────
    public function index()
    {
        $schedules = CounselorSchedule::where('counselor_id', Auth::id())
            ->orderByRaw("FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday')")
            ->get();

        return view('CounselConnect.counselor.schedule.index', compact('schedules'));
    }

    // ─── Show Create Form ────────────────────────────────────────
    public function create()
    {
        return view('CounselConnect.counselor.schedule.create');
    }

    // ─── Store Schedule ──────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'day_of_week'        => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday'],
            'start_time'         => ['required', 'date_format:H:i'],
            'end_time'           => ['required', 'date_format:H:i', 'after:start_time'],
            'slot_duration_mins' => ['required', 'integer', 'min:15', 'max:120'],
        ]);

        CounselorSchedule::create([
            ...$data,
            'counselor_id' => Auth::id(),
            'is_active'    => true,
        ]);

        return redirect()->route('counselor.schedule.index')
            ->with('success', 'Schedule added successfully.');
    }

    // ─── Show Single Schedule ─────────────────────────────────────
    public function show(CounselorSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $schedule->load('appointments.student.studentProfile');

        return view('CounselConnect.counselor.schedule.show', compact('schedule'));
    }

    // ─── Show Edit Form ──────────────────────────────────────────
    public function edit(CounselorSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        return view('CounselConnect.counselor.schedule.edit', compact('schedule'));
    }

    // ─── Update Schedule ─────────────────────────────────────────
    public function update(Request $request, CounselorSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $data = $request->validate([
            'day_of_week'        => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday'],
            'start_time'         => ['required', 'date_format:H:i'],
            'end_time'           => ['required', 'date_format:H:i', 'after:start_time'],
            'slot_duration_mins' => ['required', 'integer', 'min:15', 'max:120'],
            'is_active'          => ['boolean'],
        ]);

        $schedule->update($data);

        return redirect()->route('counselor.schedule.index')
            ->with('success', 'Schedule updated successfully.');
    }

    // ─── Delete Schedule ─────────────────────────────────────────
    public function destroy(CounselorSchedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $schedule->delete();

        return redirect()->route('counselor.schedule.index')
            ->with('success', 'Schedule deleted.');
    }

    // ─── Guard: Only Own Schedules ───────────────────────────────
    private function authorizeSchedule(CounselorSchedule $schedule): void
    {
        abort_if($schedule->counselor_id !== Auth::id(), 403);
    }
}