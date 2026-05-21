<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────
        User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@counselconnect.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // ── Counselors ─────────────────────────────────────────
        User::create([
            'name'              => 'Dr. Meredith Gray',
            'email'             => 'meredith.gray@counselconnect.com',
            'password'          => Hash::make('password'),
            'role'              => 'counselor',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Dr. James Reyes',
            'email'             => 'james.reyes@counselconnect.com',
            'password'          => Hash::make('password'),
            'role'              => 'counselor',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Ms. Sofia Navarro',
            'email'             => 'sofia.navarro@counselconnect.com',
            'password'          => Hash::make('password'),
            'role'              => 'counselor',
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // ── Students ───────────────────────────────────────────
        $students = [
            ['name' => 'Rendell Jhon Alfanta',  'email' => 'rendell.alfanta@student.com'],
            ['name' => 'Maria Clara Santos',     'email' => 'maria.santos@student.com'],
            ['name' => 'Liam Dela Cruz',         'email' => 'liam.delacruz@student.com'],
            ['name' => 'Angela Reyes',           'email' => 'angela.reyes@student.com'],
            ['name' => 'Carlos Mendoza',         'email' => 'carlos.mendoza@student.com'],
            ['name' => 'Jasmine Villanueva',     'email' => 'jasmine.villanueva@student.com'],
            ['name' => 'Paolo Bautista',         'email' => 'paolo.bautista@student.com'],
            ['name' => 'Nicole Tan',             'email' => 'nicole.tan@student.com'],
        ];

        foreach ($students as $student) {
            User::create([
                'name'              => $student['name'],
                'email'             => $student['email'],
                'password'          => Hash::make('password'),
                'role'              => 'student',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]);
        }
    }
}
