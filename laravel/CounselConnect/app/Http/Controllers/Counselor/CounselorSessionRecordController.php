<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\SessionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselorSessionRecordController extends Controller
{
    // ─── List Session Records ────────────────────────────────────
    public function index(Request $request)
    {
        $records = SessionRecord::where('counselor_id', Auth::id())
            ->with('student.studentProfile', 'appointment')
            ->when($request->follow_up, fn($q) => $q->needsFollowUp())
            ->latest()
            ->paginate(15);

        return view('CounselConnect.counselor.sessions.index', compact('records'));
    }

    // ─── Show Create Form ────────────────────────────────────────
    public function create(Request $request)
    {
        $appointment = Appointment::findOrFail($request->appointment);

        abort_if($appointment->counselor_id !== Auth::id(), 403);
        abort_if(! $appointment->isCompleted(), 422, 'Appointment must be completed first.');
        abort_if($appointment->sessionRecord()->exists(), 422, 'Session record already exists.');

        return view('CounselConnect.counselor.sessions.create', compact('appointment'));
    }

    // ─── Store Session Record ────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id'    => ['required', 'exists:appointments,id'],
            'session_notes'     => ['required', 'string'],
            'intervention'      => ['nullable', 'string', 'max:255'],
            'follow_up_needed'  => ['boolean'],
            'next_session_date' => ['nullable', 'date', 'after:today', 'required_if:follow_up_needed,true'],
        ]);

        $appointment = Appointment::findOrFail($data['appointment_id']);

        abort_if($appointment->counselor_id !== Auth::id(), 403);

        $record = SessionRecord::create([
            ...$data,
            'counselor_id' => Auth::id(),
            'student_id'   => $appointment->student_id,
        ]);

        return redirect()->route('counselor.sessions.show', $record)
            ->with('success', 'Session record saved successfully.');
    }

    // ─── Show Single Record ──────────────────────────────────────
    public function show(SessionRecord $sessionRecord)
    {
        $this->authorizeRecord($sessionRecord);

        $sessionRecord->load(['student.studentProfile', 'appointment']);

        return view('CounselConnect.counselor.sessions.show', compact('sessionRecord'));
    }

    // ─── Show Edit Form ──────────────────────────────────────────
    public function edit(SessionRecord $sessionRecord)
    {
        $this->authorizeRecord($sessionRecord);

        return view('CounselConnect.counselor.sessions.edit', compact('sessionRecord'));
    }

    // ─── Update Session Record ───────────────────────────────────
    public function update(Request $request, SessionRecord $sessionRecord)
    {
        $this->authorizeRecord($sessionRecord);

        $data = $request->validate([
            'session_notes'     => ['required', 'string'],
            'intervention'      => ['nullable', 'string', 'max:255'],
            'follow_up_needed'  => ['boolean'],
            'next_session_date' => ['nullable', 'date', 'after:today', 'required_if:follow_up_needed,true'],
        ]);

        $sessionRecord->update($data);

        return redirect()->route('counselor.sessions.show', $sessionRecord)
            ->with('success', 'Session record updated.');
    }

    // Session records should not be deleted — they are permanent records
    public function destroy(SessionRecord $sessionRecord)
    {
        abort(403, 'Session records cannot be deleted.');
    }

    // ─── Guard: Only Own Records ─────────────────────────────────
    private function authorizeRecord(SessionRecord $sessionRecord): void
    {
        abort_if($sessionRecord->counselor_id !== Auth::id(), 403);
    }
}