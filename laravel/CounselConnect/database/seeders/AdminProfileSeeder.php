<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Adminprofile;

class AdminProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();

        Adminprofile::firstOrCreate(
            ['user_id' => $user->id]
        );
    }
}
