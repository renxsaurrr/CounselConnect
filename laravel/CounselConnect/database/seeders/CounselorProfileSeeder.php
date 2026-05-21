<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Counselorprofile;

class CounselorProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'email'           => 'meredith.gray@counselconnect.com',
                'specialization'  => 'Career Counseling',
                'office_location' => 'Guidance Office, Room 101',
                'contact_number'  => '09171234567',
                'bio'             => 'Experienced career counselor helping students navigate their professional paths for over 10 years.',
            ],
            [
                'email'           => 'james.reyes@counselconnect.com',
                'specialization'  => 'Mental Health Counseling',
                'office_location' => 'Guidance Office, Room 102',
                'contact_number'  => '09289876543',
                'bio'             => 'Licensed psychologist specializing in anxiety, stress management, and student well-being.',
            ],
            [
                'email'           => 'sofia.navarro@counselconnect.com',
                'specialization'  => 'Academic Counseling',
                'office_location' => 'Guidance Office, Room 103',
                'contact_number'  => '09354445678',
                'bio'             => 'Dedicated academic counselor supporting students with learning strategies and academic planning.',
            ],
        ];

        foreach ($profiles as $profile) {
            $user = User::where('email', $profile['email'])->first();

            CounselorProfile::create([
                'user_id'         => $user->id,
                'specialization'  => $profile['specialization'],
                'office_location' => $profile['office_location'],
                'contact_number'  => $profile['contact_number'],
                'bio'             => $profile['bio'],
            ]);
        }
    }
}
