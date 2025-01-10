<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cohort;
use App\Models\Lesson;
use Carbon\Carbon;

class CohortLesson extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cohorts = Cohort::all();
        $lessons = Lesson::all();

        foreach ($cohorts as $cohort) {
            // Randomly pick 10 lessons for the cohort
            $selectedLessons = $lessons->random(10);

            foreach ($selectedLessons as $lesson) {
                // Generate a random date within the next 12 months
                $randomDate = Carbon::now()->addDays(rand(1, 365));

                // Attach the lesson to the cohort with a pivot table entry
                $cohort->lessons()->attach($lesson->id, ['date' => $randomDate]);
            }
        }
    }
}
