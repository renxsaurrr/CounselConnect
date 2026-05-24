<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CounselorProfile;

class CounselorProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'meredith.gray@counselconnect.com')->first();

        CounselorProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'specialization'  => 'Career Counseling',
                'office_location' => 'Guidance Office, Room 101',
                'contact_number'  => '09171234567',
                'bio'             => 'Experienced career counselor helping students navigate their professional paths for over 10 years.',
            ]
        );
    }
}
