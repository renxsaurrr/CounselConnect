<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Appointment;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $meredith = User::where('email', 'meredith.gray@counselconnect.com')->first();
        $james    = User::where('email', 'james.reyes@counselconnect.com')->first();
        $sofia    = User::where('email', 'sofia.navarro@counselconnect.com')->first();

        $rendell  = User::where('email', 'rendell.alfanta@student.com')->first();
        $maria    = User::where('email', 'maria.santos@student.com')->first();
        $liam     = User::where('email', 'liam.delacruz@student.com')->first();
        $angela   = User::where('email', 'angela.reyes@student.com')->first();
        $carlos   = User::where('email', 'carlos.mendoza@student.com')->first();
        $jasmine  = User::where('email', 'jasmine.villanueva@student.com')->first();
        $paolo    = User::where('email', 'paolo.bautista@student.com')->first();
        $nicole   = User::where('email', 'nicole.tan@student.com')->first();

        $appointments = [

            // ── Approved (student-initiated) ───────────────────────────────
            [
                'student_id'     => $rendell->id,
                'counselor_id'   => $meredith->id,
                'concern_type'   => 'Personal',
                'notes'          => 'I have been feeling overwhelmed lately and would like to talk to someone.',
                'status'         => 'approved',
                'preferred_date' => '2026-05-25',
                'preferred_time' => '17:00:00',
                'scheduled_at'   => '2026-05-25 17:00:00',
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Approved (counselor-initiated invite, student accepted) ─────
            [
                'student_id'     => $maria->id,
                'counselor_id'   => $james->id,
                'concern_type'   => 'Mental Health',
                'notes'          => 'Follow-up session for previously reported stress-related concerns.',
                'status'         => 'approved',
                'preferred_date' => '2026-05-27',
                'preferred_time' => '10:00:00',
                'scheduled_at'   => '2026-05-27 10:00:00',
                'initiated_by'   => 'counselor',
                'invite_status'  => 'accepted',
            ],

            // ── Pending (student-initiated) ────────────────────────────────
            [
                'student_id'     => $liam->id,
                'counselor_id'   => $sofia->id,
                'concern_type'   => 'Academic',
                'notes'          => 'I need guidance on my course load for next semester.',
                'status'         => 'pending',
                'preferred_date' => '2026-05-28',
                'preferred_time' => '09:00:00',
                'scheduled_at'   => null,
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Pending invite (counselor-initiated, student hasn't responded) ──
            [
                'student_id'     => $angela->id,
                'counselor_id'   => $meredith->id,
                'concern_type'   => 'Career',
                'notes'          => 'I would like to discuss your post-graduation plans and career options.',
                'status'         => 'pending',
                'preferred_date' => '2026-05-30',
                'preferred_time' => '14:00:00',
                'scheduled_at'   => null,
                'initiated_by'   => 'counselor',
                'invite_status'  => 'pending',
            ],

            // ── Completed ──────────────────────────────────────────────────
            [
                'student_id'     => $jasmine->id,
                'counselor_id'   => $sofia->id,
                'concern_type'   => 'Academic',
                'notes'          => 'Discussion about shifting to a different program.',
                'status'         => 'completed',
                'preferred_date' => '2026-05-10',
                'preferred_time' => '08:30:00',
                'scheduled_at'   => '2026-05-10 08:30:00',
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            [
                'student_id'     => $paolo->id,
                'counselor_id'   => $james->id,
                'concern_type'   => 'Personal',
                'notes'          => 'Family-related stress affecting academic performance.',
                'status'         => 'completed',
                'preferred_date' => '2026-05-08',
                'preferred_time' => '13:00:00',
                'scheduled_at'   => '2026-05-08 13:00:00',
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Rejected ───────────────────────────────────────────────────
            [
                'student_id'     => $carlos->id,
                'counselor_id'   => $meredith->id,
                'concern_type'   => 'Career',
                'notes'          => 'Unsure about my chosen course and career path.',
                'status'         => 'rejected',
                'preferred_date' => '2026-05-15',
                'preferred_time' => '15:00:00',
                'scheduled_at'   => null,
                'rejection_reason' => 'The requested date conflicts with an existing school event. Please reschedule.',
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Cancelled ──────────────────────────────────────────────────
            [
                'student_id'     => $nicole->id,
                'counselor_id'   => $sofia->id,
                'concern_type'   => 'Academic',
                'notes'          => 'Need help understanding my academic standing.',
                'status'         => 'cancelled',
                'preferred_date' => '2026-05-12',
                'preferred_time' => '10:00:00',
                'scheduled_at'   => null,
                'initiated_by'   => 'student',
                'invite_status'  => null,
            ],

            // ── Declined invite (counselor-initiated, student declined) ────
            [
                'student_id'     => $liam->id,
                'counselor_id'   => $james->id,
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
