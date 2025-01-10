<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function index(): RedirectResponse
    {

        $user = Auth::user();

        if(!$user){
            return redirect()->route('login'); // Redirect to the login page if not authenticated
        }

        if ($user->hasRole('learner')) {
            return redirect()->route('learner.dashboard');
        }

        if ($user->hasRole('manager')) {
            return redirect()->route('manager.dashboard');
        }

        if ($user->hasRole('coach')) {
            return redirect()->route('coach.dashboard'); 
        }

        // Default fallback for undefined roles
        return redirect()->route('login'); // Redirect to the login page if not authenticated
    }
}
