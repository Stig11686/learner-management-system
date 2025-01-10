<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            CohortSeeder::class,
            LessonSeeder::class,
            CohortLesson::class,
            KsbSeeder::class,
            RolesAndPermissionsSeeder::class, 
            UserSeeder::class, 
            CohortLearner::class,
            TrainingPlanSeeder::class,
        ]);
    
    }
}
