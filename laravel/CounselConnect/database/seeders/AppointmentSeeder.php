<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $counselor = User::where('email', 'meredith.gray@counselconnect.com')->first();
        $student   = User::where('email', 'rendellalfanta@gmail.com')->first();

        $appointments = [

            // ── Approved (student-initiated) ───────────────────────────────
            [
                'student_id'     => $student->id,
                'counselor_id'   => $counselor->id,
                'concern_type'   => 'Personal',
                'notes'          => 'I have been feeling overwhelmed lately and would like to talk to someone.',
                'status'         => 'approved',
                'preferred_date' => '2026-05-25',
                'preferred_time' => '09:00:00',
                'scheduled_at'   => '2026-05-25 09:00:00',
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Pending (student-initiated) ────────────────────────────────
            [
                'student_id'     => $student->id,
                'counselor_id'   => $counselor->id,
                'concern_type'   => 'Academic',
                'notes'          => 'I need guidance on my course load for next semester.',
                'status'         => 'pending',
                'preferred_date' => '2026-06-02',
                'preferred_time' => '10:00:00',
                'scheduled_at'   => null,
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Pending invite (counselor-initiated, student hasn't responded) ──
            [
                'student_id'     => $student->id,
                'counselor_id'   => $counselor->id,
                'concern_type'   => 'Career',
                'notes'          => 'I would like to discuss your post-graduation plans and career options.',
                'status'         => 'pending',
                'preferred_date' => '2026-06-05',
                'preferred_time' => '14:00:00',
                'scheduled_at'   => null,
                'initiated_by'   => 'counselor',
                'invite_status'  => 'pending',
            ],

            // ── Completed ──────────────────────────────────────────────────
            [
                'student_id'     => $student->id,
                'counselor_id'   => $counselor->id,
                'concern_type'   => 'Academic',
                'notes'          => 'Discussion about shifting to a different program.',
                'status'         => 'completed',
                'preferred_date' => '2026-05-10',
                'preferred_time' => '08:00:00',
                'scheduled_at'   => '2026-05-10 08:00:00',
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Completed (counselor-initiated, student accepted) ──────────
            [
                'student_id'     => $student->id,
                'counselor_id'   => $counselor->id,
                'concern_type'   => 'Mental Health',
                'notes'          => 'Follow-up check-in on student well-being and stress levels.',
                'status'         => 'completed',
                'preferred_date' => '2026-05-17',
                'preferred_time' => '10:00:00',
                'scheduled_at'   => '2026-05-17 10:00:00',
                'initiated_by'   => 'counselor',
                'invite_status'  => 'accepted',
            ],

            // ── Rejected ───────────────────────────────────────────────────
            [
                'student_id'       => $student->id,
                'counselor_id'     => $counselor->id,
                'concern_type'     => 'Career',
                'notes'            => 'Unsure about my chosen course and career path.',
                'status'           => 'rejected',
                'preferred_date'   => '2026-05-15',
                'preferred_time'   => '15:00:00',
                'scheduled_at'     => null,
                'rejection_reason' => 'The requested time slot is already fully booked. Please choose another date.',
                'initiated_by'     => 'student',
                'invite_status'    => null,
            ],

            // ── Cancelled ──────────────────────────────────────────────────
            [
                'student_id'     => $student->id,
                'counselor_id'   => $counselor->id,
                'concern_type'   => 'Academic',
                'notes'          => 'Need help understanding my academic standing.',
                'status'         => 'cancelled',
                'preferred_date' => '2026-05-12',
                'preferred_time' => '11:00:00',
                'scheduled_at'   => null,
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Declined invite (counselor-initiated, student declined) ────
            [
                'student_id'     => $student->id,
                'counselor_id'   => $counselor->id,
                'concern_type'   => 'Mental Health',
                'notes'          => 'Checking in on student well-being based on faculty referral.',
                'status'         => 'cancelled',
                'preferred_date' => '2026-05-20',
                'preferred_time' => '11:00:00',
                'scheduled_at'   => null,
                'initiated_by'   => 'counselor',
                'invite_status'  => 'declined',
            ],
        ];

        foreach ($appointments as $data) {
            Appointment::create($data);
        }
    }
}
