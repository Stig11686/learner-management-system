<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learner;

class CoachLearnersController extends Controller
{
    public function index()
    {
        $trainer = auth()->user()->trainer;
        
        $learners = Learner::with('user')->where('trainer_id', $trainer->id)->get();

        return view('coach.learners', [
            'learners' => $learners,
        ]);
    }

    public function show($id)
    {
        $learner = Learner::findOrFail($id);

        return view('coach.learner', [
            'learner' => $learner,
        ]);
    }
}
