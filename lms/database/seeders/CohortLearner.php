<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Learner;
use App\Models\Cohort;

class CohortLearner extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $learners = Learner::all();
        $cohorts = Cohort::all();

        foreach($learners as $learner){
            $learner->cohort()->associate($cohorts->random());
            $learner->save();
        }
    }
}
