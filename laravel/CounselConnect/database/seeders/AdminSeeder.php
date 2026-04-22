<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdminProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'               => 'Super Admin',
            'email'              => 'admin@counselconnect.com',
            'password'           => Hash::make('admin123'),
            'role'               => 'admin',
            'is_active'          => true,
            'email_verified_at'  => now(),
        ]);

        AdminProfile::create([
            'user_id' => $user->id,
        ]);
    }
}