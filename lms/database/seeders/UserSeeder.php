<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Learner;
use App\Models\Trainer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $managerUser = User::create([
            'name' => 'Shelley',
            'email' => 'manager@example.com',
            'password' => 'Erding3r!',
        ]);

        $managerUser->assignRole('manager');

        $coachUser = User::create([
            'name' => 'Steve',
            'email' => 'steve@thecodersguild.org.uk',
            'password' => 'Erding3r!'
        ]);

        $coachUser->assignRole('coach');

        $trainer = Trainer::create([
            'user_id' => $coachUser->id,
        ]);

        // Create a learner user
        $learnerUser = User::create([
            'name' => 'Learner User',
            'email' => 'learner@example.com',
            'password' => 'Erding3r!'
        ]);

        $learnerUser->assignRole('learner');

        // Attach additional learner data
        Learner::create([
            'user_id' => $learnerUser->id,
            'employer' => 'BVSWebDesign',
            'start_date' => now()->subMonths(6),
            'otjh_target' => 318,
            'otjh_actual' => 0,
            'drive_link' => '',
            'end_date' => now()->addMonths(12),
            'rag_rating' => 'amber',
            'trainer_id' => $trainer->id
        ]);

    }

}
