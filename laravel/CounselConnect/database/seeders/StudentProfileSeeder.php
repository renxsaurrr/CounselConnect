<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;

class StudentProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'rendellalfanta@gmail.com')->first();

        StudentProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'student_id' => '2023-00142',
                'department' => 'BSIT',
                'year_level' => '2nd Year',
                'bio'        => 'Passionate about web development and UI/UX design.',
            ]
        );
    }
}
