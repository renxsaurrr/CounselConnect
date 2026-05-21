<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StudentProfileSeeder::class,
            CounselorProfileSeeder::class,
            AdminProfileSeeder::class,
            CounselorScheduleSeeder::class,
            AppointmentSeeder::class,
            SessionRecordSeeder::class,
            ReferralSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
