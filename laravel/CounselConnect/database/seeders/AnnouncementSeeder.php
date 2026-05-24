<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $admin     = User::where('email', 'gray@gmail.com')->first();
        $counselor = User::where('email', 'meredith.gray@counselconnect.com')->first();

        $announcements = [

            // Published — all
            [
                'posted_by'    => $admin->id,
                'title'        => 'Welcome to CounselConnect!',
                'body'         => 'We are excited to launch the CounselConnect portal — your one-stop platform for scheduling counseling appointments, tracking sessions, and accessing guidance resources. For concerns or technical issues, please contact the Guidance Office.',
                'audience'     => 'all',
                'is_published' => true,
            ],

            // Published — students only
            [
                'posted_by'    => $counselor->id,
                'title'        => 'Career Planning Workshop — June 10, 2026',
                'body'         => 'Attention students! Join us for a free Career Planning Workshop on June 10, 2026, from 1:00 PM to 4:00 PM at the AVR. Topics include resume writing, job hunting strategies, and career path planning. Slots are limited — book your appointment on this portal to reserve a seat.',
                'audience'     => 'students',
                'is_published' => true,
            ],

            // Published — counselors only
            [
                'posted_by'    => $admin->id,
                'title'        => 'Counselor Case Conference — June 3, 2026',
                'body'         => 'All counselors are required to attend the monthly case conference on June 3, 2026, at 9:00 AM in the Guidance Conference Room. Please bring updated case notes and referral documentation. Agenda will be shared via email.',
                'audience'     => 'counselors',
                'is_published' => true,
            ],

            // Published — all
            [
                'posted_by'    => $counselor->id,
                'title'        => 'Reminder: Keep Your Profile Updated',
                'body'         => 'Please make sure your profile information is up to date on the CounselConnect portal. Accurate contact details and department information help us serve you better. Log in and visit your profile page to review your details.',
                'audience'     => 'students',
                'is_published' => true,
            ],

            // Draft — not yet published
            [
                'posted_by'    => $admin->id,
                'title'        => 'Mental Health Awareness Month — June 2026',
                'body'         => 'June is Mental Health Awareness Month. The Guidance and Counseling Office will be hosting a series of activities including free stress assessments, mindfulness workshops, and open counseling days. Watch out for more announcements!',
                'audience'     => 'all',
                'is_published' => false,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
