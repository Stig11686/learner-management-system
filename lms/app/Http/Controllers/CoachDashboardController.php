<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Learner;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;

class CoachDashboardController extends Controller
{
    public function index()
    {
        $user = User::role('coach')->where('id', Auth::id())->first();

        $trainer = Trainer::where('user_id', $user->id)->first();

        $learners = Learner::with('user')
        ->where('trainer_id', $trainer->id)
        ->get();
        
        $ragRatingCounts = [
            'red' => $learners->where('rag_rating', 'red')->count(),
            'amber' => $learners->where('rag_rating', 'amber')->count(),
            'green' => $learners->where('rag_rating', 'green')->count(),
        ];

        $chartData = [
            'rag_rating' => $ragRatingCounts,
        ];

        return view('coach.dashboard', [
            'user' => $user,
            'learners' => $learners,
            'chartData' => $chartData,
        ]);

    }
}
