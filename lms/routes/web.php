<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LearnerDashboardController;
use App\Http\Controllers\TrainingPlanController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\CoachDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoachLearnersController;
use App\Http\Controllers\CohortController;
use App\Http\Controllers\LearnerController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:learner'])->group(function () {
    Route::get('/learner/dashboard', [LearnerDashboardController::class, 'index'])->name('learner.dashboard');
    Route::get('/learner/training-plan', [TrainingPlanController::class, 'index'])->name('learner.training-plan');
});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
});

Route::middleware(['auth', 'role:coach'])->group(function () {
    Route::get('/coach/dashboard', [CoachDashboardController::class, 'index'])->name('coach.dashboard');
});

Route::middleware(['auth', 'permission:view-learners'])->group(function(){
    Route::get('/learners', [LearnerController::class, 'index'])->name('learners.index');
    Route::get('/learners/{learner}', [LearnerController::class, 'show'])->name('learners.show');
});

Route::middleware(['auth', 'permission:view-cohorts'])->group(function() {
    Route::get('/cohorts', [CohortController::class, 'index'])->name('cohorts.index');
});


require __DIR__.'/auth.php';
