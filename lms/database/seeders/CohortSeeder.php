<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cohort;

class CohortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cohorts = ['Kingfisher', 'Penguin', 'Dolphin', 'Shark', 'Whale'];

        foreach ($cohorts as $cohort) {
            Cohort::create([
                'name' => $cohort,
                'course_id' => rand(1, 9),
            ]);
        }
    }
}
