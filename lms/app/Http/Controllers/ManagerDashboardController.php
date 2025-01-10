<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Learner;
use Illuminate\Support\Facades\Auth;

class ManagerDashboardController extends Controller
{
    //
    public function index()
    {
        // Fetch the logged-in manager
        $manager = User::role('manager')->where('id', Auth::id())->first();

        // Fetch all learners
        $learners = Learner::with('user')->get();

        // Count learners by RAG rating
        $ragRatingCounts = [
            'red' => $learners->where('rag_rating', 'red')->count(),
            'amber' => $learners->where('rag_rating', 'amber')->count(),
            'green' => $learners->where('rag_rating', 'green')->count(),
        ];

        // Prepare data for future charts
        $chartData = [
            'rag_rating' => $ragRatingCounts,
            // Additional data for other charts can be added here
        ];

        return view('manager.dashboard', [
            'manager' => $manager,
            'learners' => $learners,
            'chartData' => $chartData,
        ]);
    }

}
