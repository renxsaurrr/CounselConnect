<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Counselorschedule;

class CounselorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            // Dr. Meredith Gray — Mon, Wed, Fri
            [
                'email'              => 'meredith.gray@counselconnect.com',
                'day_of_week'        => 'Monday',
                'start_time'         => '08:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],
            [
                'email'              => 'meredith.gray@counselconnect.com',
                'day_of_week'        => 'Wednesday',
                'start_time'         => '08:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],
            [
                'email'              => 'meredith.gray@counselconnect.com',
                'day_of_week'        => 'Friday',
                'start_time'         => '08:00:00',
                'end_time'           => '12:00:00',
                'slot_duration_mins' => 60,
            ],

            // Dr. James Reyes — Tue, Thu
            [
                'email'              => 'james.reyes@counselconnect.com',
                'day_of_week'        => 'Tuesday',
                'start_time'         => '09:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],
            [
                'email'              => 'james.reyes@counselconnect.com',
                'day_of_week'        => 'Thursday',
                'start_time'         => '09:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],

            // Ms. Sofia Navarro — Mon to Fri
            [
                'email'              => 'sofia.navarro@counselconnect.com',
                'day_of_week'        => 'Monday',
                'start_time'         => '08:00:00',
                'end_time'           => '12:00:00',
                'slot_duration_mins' => 30,
            ],
            [
                'email'              => 'sofia.navarro@counselconnect.com',
                'day_of_week'        => 'Tuesday',
                'start_time'         => '08:00:00',
                'end_time'           => '12:00:00',
                'slot_duration_mins' => 30,
            ],
            [
                'email'              => 'sofia.navarro@counselconnect.com',
                'day_of_week'        => 'Wednesday',
                'start_time'         => '13:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 30,
            ],
            [
                'email'              => 'sofia.navarro@counselconnect.com',
                'day_of_week'        => 'Thursday',
                'start_time'         => '13:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 30,
            ],
            [
                'email'              => 'sofia.navarro@counselconnect.com',
                'day_of_week'        => 'Friday',
                'start_time'         => '08:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 30,
            ],
        ];

        foreach ($schedules as $schedule) {
            $counselor = User::where('email', $schedule['email'])->first();

            Counselorschedule::create([
                'counselor_id'       => $counselor->id,
                'day_of_week'        => $schedule['day_of_week'],
                'start_time'         => $schedule['start_time'],
                'end_time'           => $schedule['end_time'],
                'slot_duration_mins' => $schedule['slot_duration_mins'],
                'is_active'          => true,
            ]);
        }
    }
}
