<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Carbon\Carbon;

class TrainingPlan extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct($learner)
    {
        $this->learner = $learner;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cohortLessons = $this->learner->cohort->lessons->map(function ($lesson) {
            return [
                'type' => 'lesson',
                'name' => $lesson->name,
                'date' => $lesson->pivot->date,
                'duration' => $lesson->pivot->duration,
            ];
        });

        $coachingMeetings = $this->learner->coaching_meetings->map(function ($meeting) {
            return [
                'type' => 'coaching_meeting',
                'name' => 'Coaching Meeting',
                'date' => $meeting->date,
                'duration' => $meeting->duration,
            ];
        });

        $progressReviews = $this->learner->progress_reviews->map(function ($review) {
            return [
                'type' => 'progress_review',
                'name' => 'Progress Review',
                'date' => $review->date,
                'duration' => $review->duration,
            ];
        });

        // Combine and sort by date
        $trainingPlan = $cohortLessons
            ->concat($coachingMeetings)
            ->concat($progressReviews)
            ->sortBy('date')
            ->values(); // Reindex the collection

        $today = Carbon::today();
        $sixWeeksFromToday = $today->copy()->addWeeks(6);

        $upcomingTrainingPlan = $trainingPlan->filter(function ($session) use ($today, $sixWeeksFromToday) {
        return Carbon::parse($session['date'])->between($today, $sixWeeksFromToday);
        })->values();
        
        return view('components.training-plan', [
            'training_plan' => $upcomingTrainingPlan,
        ]);
    }
}
