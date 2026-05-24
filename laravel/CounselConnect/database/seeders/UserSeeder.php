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
        User::firstOrCreate(
            ['email' => 'gray@gmail.com'],
            [
                'name'              => 'Admin User',
                'password'          => Hash::make('lledner123'),
                'role'              => 'admin',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        // ── Counselor ──────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'meredith.gray@counselconnect.com'],
            [
                'name'              => 'Dr. Meredith Gray',
                'password'          => Hash::make('lledner123'),
                'role'              => 'counselor',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        // ── Student ────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'rendellalfanta@gmail.com'],
            [
                'name'              => 'Rendell Jhon Alfanta',
                'password'          => Hash::make('lledner123'),
                'role'              => 'student',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
