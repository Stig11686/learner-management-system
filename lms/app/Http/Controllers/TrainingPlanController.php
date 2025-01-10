<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learner;
use Illuminate\Support\Facades\Auth;


class TrainingPlanController extends Controller
{
    public function index()
    {
        $learner = Learner::with([
            'user',
            'cohort',
            'cohort.course', 
            'cohort.lessons' => function($query){
                $query->withPivot(['date', 'duration']);
            }, 
            'coaching_meetings', 
            'progress_reviews'])
            ->where('user_id', Auth::id())
            ->first();

            $cohortLessons = $learner->cohort->lessons->map(function ($lesson) {
                return [
                    'type' => 'lesson',
                    'name' => $lesson->name,
                    'date' => $lesson->pivot->date,
                    'duration' => $lesson->pivot->duration,
                ];
            });
    
            $coachingMeetings = $learner->coaching_meetings->map(function ($meeting) {
                return [
                    'type' => 'coaching_meeting',
                    'name' => 'Coaching Meeting',
                    'date' => $meeting->date,
                    'duration' => $meeting->duration,
                ];
            });
    
            $progressReviews = $learner->progress_reviews->map(function ($review) {
                return [
                    'type' => 'progress_review',
                    'name' => 'Progress Review',
                    'date' => $review->date,
                    'duration' => $review->duration,
                ];
            });
    
            // Combine and sort by date
            $training_plan = $cohortLessons
                ->concat($coachingMeetings)
                ->concat($progressReviews)
                ->sortBy('date')
                ->values(); // Reindex the collection
    

        return view('learner.training-plan', [
            'learner' => $learner,
            'training_plan' => $training_plan
        ]);
    }
}
