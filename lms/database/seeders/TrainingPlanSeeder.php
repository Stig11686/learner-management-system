<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Learner;
use App\Models\CoachingMeeting;
use App\Models\ProgressReview;
use Carbon\Carbon;

class TrainingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $learners = Learner::all();

        foreach ($learners as $learner) {
            $start_date = Carbon::parse($learner->start_date);
            $end_date = Carbon::parse($learner->end_date);

            // Generate coaching meetings (monthly)
            $coaching_date = $start_date->copy();
            while ($coaching_date <= $end_date) {
                CoachingMeeting::create([
                    'learner_id' => $learner->id,
                    'date' => $coaching_date,
                ]);
                $coaching_date->addMonth(); // Increment by one month
            }

            // Generate progress reviews (every 2 months)
            $review_date = $start_date->copy();
            while ($review_date <= $end_date) {
                ProgressReview::create([
                    'learner_id' => $learner->id,
                    'date' => $review_date,
                ]);
                $review_date->addMonths(2); // Increment by two months
            }
        }
    }
}
