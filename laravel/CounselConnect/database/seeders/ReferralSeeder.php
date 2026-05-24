<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Referral;

class ReferralSeeder extends Seeder
{
    public function run(): void
    {
        $counselor = User::where('email', 'meredith.gray@counselconnect.com')->first();
        $student   = User::where('email', 'rendellalfanta@gmail.com')->first();
        $admin     = User::where('email', 'gray@gmail.com')->first();

        $referrals = [

            // Internal referral: counselor refers student to admin (acting as another officer)
            [
                'referred_by' => $counselor->id,
                'referred_to' => $admin->id,
                'student_id'  => $student->id,
                'reason'      => 'Student shows signs of persistent anxiety and low self-esteem beyond the scope of career counseling. Referring for further assessment and support.',
                'type'        => 'internal',
                'status'      => 'acknowledged',
            ],

            // External referral: counselor refers student to an outside professional
            [
                'referred_by' => $counselor->id,
                'referred_to' => $counselor->id, // self-logged external referral
                'student_id'  => $student->id,
                'reason'      => 'Student\'s reported mental health symptoms exceed what can be addressed within the school guidance scope. Referring to a licensed clinical psychologist for professional evaluation.',
                'type'        => 'external',
                'status'      => 'pending',
            ],

            // Internal referral: admin refers student back to counselor for follow-up
            [
                'referred_by' => $admin->id,
                'referred_to' => $counselor->id,
                'student_id'  => $student->id,
                'reason'      => 'Student submitted a concern via the portal regarding difficulty adjusting to college life. Recommending a follow-up counseling session.',
                'type'        => 'internal',
                'status'      => 'pending',
            ],
        ];

        foreach ($referrals as $referral) {
            Referral::create($referral);
        }
    }
}
