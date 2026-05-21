<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;

class StudentProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'email'       => 'rendell.alfanta@student.com',
                'student_id'  => '2023-00142',
                'department'  => 'BSIT',
                'year_level'  => '2nd Year',
                'bio'         => 'Passionate about web development and UI/UX design.',
            ],
            [
                'email'       => 'maria.santos@student.com',
                'student_id'  => '2022-00089',
                'department'  => 'BSN',
                'year_level'  => '3rd Year',
                'bio'         => 'Aspiring nurse with a passion for mental health advocacy.',
            ],
            [
                'email'       => 'liam.delacruz@student.com',
                'student_id'  => '2023-00211',
                'department'  => 'BSCS',
                'year_level'  => '2nd Year',
                'bio'         => 'Interested in AI and machine learning.',
            ],
            [
                'email'       => 'angela.reyes@student.com',
                'student_id'  => '2021-00056',
                'department'  => 'BSBA',
                'year_level'  => '4th Year',
                'bio'         => 'Business management student focused on entrepreneurship.',
            ],
            [
                'email'       => 'carlos.mendoza@student.com',
                'student_id'  => '2023-00334',
                'department'  => 'BSCE',
                'year_level'  => '1st Year',
                'bio'         => 'Civil engineering freshman eager to learn.',
            ],
            [
                'email'       => 'jasmine.villanueva@student.com',
                'student_id'  => '2022-00178',
                'department'  => 'BSED',
                'year_level'  => '3rd Year',
                'bio'         => 'Future educator passionate about inclusive learning.',
            ],
            [
                'email'       => 'paolo.bautista@student.com',
                'student_id'  => '2021-00099',
                'department'  => 'BSA',
                'year_level'  => '4th Year',
                'bio'         => 'Accountancy student balancing academics and part-time work.',
            ],
            [
                'email'       => 'nicole.tan@student.com',
                'student_id'  => '2023-00412',
                'department'  => 'BSIT',
                'year_level'  => '1st Year',
                'bio'         => 'Freshman exploring different fields of technology.',
            ],
        ];

        foreach ($profiles as $profile) {
            $user = User::where('email', $profile['email'])->first();

            StudentProfile::create([
                'user_id'    => $user->id,
                'student_id' => $profile['student_id'],
                'department' => $profile['department'],
                'year_level' => $profile['year_level'],
                'bio'        => $profile['bio'],
            ]);
        }
    }
}
