<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Referral;

class ReferralSeeder extends Seeder
{
    public function run(): void
    {
        $meredith = User::where('email', 'meredith.gray@counselconnect.com')->first();
        $james    = User::where('email', 'james.reyes@counselconnect.com')->first();
        $sofia    = User::where('email', 'sofia.navarro@counselconnect.com')->first();

        $carlos  = User::where('email', 'carlos.mendoza@student.com')->first();
        $paolo   = User::where('email', 'paolo.bautista@student.com')->first();
        $maria   = User::where('email', 'maria.santos@student.com')->first();

        $referrals = [
            // Internal referral: Meredith refers Carlos to James (mental health concern)
            [
                'referred_by' => $meredith->id,
                'referred_to' => $james->id,
                'student_id'  => $carlos->id,
                'reason'      => 'Student shows signs of persistent anxiety and low self-esteem beyond academic concerns. Referring to mental health counselor for further assessment.',
                'type'        => 'internal',
                'status'      => 'acknowledged',
            ],

            // Internal referral: James refers Paolo to Sofia (academic planning)
            [
                'referred_by' => $james->id,
                'referred_to' => $sofia->id,
                'student_id'  => $paolo->id,
                'reason'      => 'Student\'s personal difficulties are impacting academic performance. Recommending academic counseling to create a recovery plan for the current semester.',
                'type'        => 'internal',
                'status'      => 'pending',
            ],

            // External referral: Sofia refers Maria to an outside professional
            [
                'referred_by' => $sofia->id,
                'referred_to' => $james->id,   // James logs the external referral internally
                'student_id'  => $maria->id,
                'reason'      => 'Student\'s reported symptoms exceed what can be addressed within the school guidance scope. Referring to a licensed clinical psychologist for professional evaluation.',
                'type'        => 'external',
                'status'      => 'pending',
            ],
        ];

        foreach ($referrals as $referral) {
            Referral::create($referral);
        }
    }
}
