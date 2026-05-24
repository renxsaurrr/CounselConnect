<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CounselorSchedule;

class CounselorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $counselor = User::where('email', 'meredith.gray@counselconnect.com')->first();

        $schedules = [
            // Monday
            [
                'day_of_week'        => 'Monday',
                'start_time'         => '08:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],
            // Tuesday
            [
                'day_of_week'        => 'Tuesday',
                'start_time'         => '08:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],
            // Wednesday
            [
                'day_of_week'        => 'Wednesday',
                'start_time'         => '08:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],
            // Thursday
            [
                'day_of_week'        => 'Thursday',
                'start_time'         => '08:00:00',
                'end_time'           => '17:00:00',
                'slot_duration_mins' => 60,
            ],
            // Friday
            [
                'day_of_week'        => 'Friday',
                'start_time'         => '08:00:00',
                'end_time'           => '12:00:00',
                'slot_duration_mins' => 60,
            ],
        ];

        foreach ($schedules as $schedule) {
            CounselorSchedule::firstOrCreate(
                [
                    'counselor_id' => $counselor->id,
                    'day_of_week'  => $schedule['day_of_week'],
                ],
                [
                    'start_time'         => $schedule['start_time'],
                    'end_time'           => $schedule['end_time'],
                    'slot_duration_mins' => $schedule['slot_duration_mins'],
                    'is_active'          => true,
                ]
            );
        }
    }
}
