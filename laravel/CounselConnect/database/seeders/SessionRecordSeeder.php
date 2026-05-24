<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\SessionRecord;

class SessionRecordSeeder extends Seeder
{
    public function run(): void
    {
        $completedAppointments = Appointment::where('status', 'completed')->get();

        $sessionData = [
            [
                'session_notes'     => 'Student expressed interest in shifting from BSED to BSIT. Discussed the requirements, academic implications, and career prospects of both programs. Student was advised to consult with the registrar and department chair before making a final decision.',
                'intervention'      => 'Person-centered counseling; information giving',
                'follow_up_needed'  => true,
                'next_session_date' => '2026-05-31',
            ],
            [
                'session_notes'     => 'Student opened up about stress related to upcoming final exams. Explored coping strategies including time management techniques and setting realistic study goals. Student reported feeling more confident after the session.',
                'intervention'      => 'Cognitive-behavioral approach; stress inoculation',
                'follow_up_needed'  => false,
                'next_session_date' => null,
            ],
        ];

        foreach ($completedAppointments as $index => $appointment) {
            $data = $sessionData[$index] ?? $sessionData[0];

            SessionRecord::create([
                'appointment_id'    => $appointment->id,
                'counselor_id'      => $appointment->counselor_id,
                'student_id'        => $appointment->student_id,
                'session_notes'     => $data['session_notes'],
                'intervention'      => $data['intervention'],
                'follow_up_needed'  => $data['follow_up_needed'],
                'next_session_date' => $data['next_session_date'],
            ]);
        }
    }
}
