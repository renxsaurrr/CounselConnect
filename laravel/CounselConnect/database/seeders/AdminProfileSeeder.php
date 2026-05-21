<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AdminProfile;

class AdminProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@counselconnect.com')->first();

        AdminProfile::create([
            'user_id' => $user->id,
        ]);
    }
}
