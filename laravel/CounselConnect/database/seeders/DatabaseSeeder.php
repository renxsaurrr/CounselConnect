<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminProfileSeeder::class,
            CounselorProfileSeeder::class,
            StudentProfileSeeder::class,
            CounselorScheduleSeeder::class,
            AppointmentSeeder::class,
            SessionRecordSeeder::class,
            ReferralSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
