<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Learner;
use Carbon\Carbon;


class LearnerDashboardController extends Controller
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

        if (!$learner) {
            abort(404, 'Learner not found');
        }

        // Combine cohort lessons, coaching meetings, and progress reviews into a single training plan
        

        return view('learner.dashboard', [
            'learner' => $learner,
        ]);
    }
}
