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
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProgressReviewController;
use App\Http\Controllers\CoachingMeetingController;
use App\Http\Controllers\OTJLogsController;
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
    
    Route::get('/learners/{learner}/otj', [OTJLogsController::class, 'indexForLearner'])
        ->name('otj.indexForLearner');
    Route::post('/learners/{learner}/otj', [OTJLogsController::class, 'store'])->name('otj.store');

});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
});

Route::middleware(['auth', 'role:coach'])->group(function () {
    Route::get('/coach/dashboard', [CoachDashboardController::class, 'index'])->name('coach.dashboard');
});

Route::middleware(['auth', 'permission:view-learners'])->group(function(){
    Route::resource('learners', LearnerController::class);
});

Route::middleware(['auth', 'permission:control-resources'])->group(function() {
    Route::resource('cohorts', CohortController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('sessions', SessionController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('progress-reviews', ProgressReviewController::class);
    Route::resource('coaching-meetings', CoachingMeetingController::class);
    Route::get('/learners/{learner}/off-the-job-logs', [OTJLogsController::class, 'showForLearner'])
        ->name('off-the-job-logs.showForLearner');
    Route::patch('/learners/{learner}/off-the-job-logs/{id}', [OTJLogsController::class, 'update'])->name('otj-logs.update');

});


require __DIR__.'/auth.php';
