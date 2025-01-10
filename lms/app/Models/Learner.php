<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $fillable = [
        'user_id', 
        'employer', 
        'start_date', 
        'end_date', 
        'target_otj_hours',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function ksbs()
    {
        return $this->hasMany(KSB::class);
    }

    public function cohort(){
        return $this->belongsTo(Cohort::class);
    }

    public function progress_reviews(){
        return $this->hasMany(ProgressReview::class);
    }

    public function coaching_meetings(){
        return $this->hasMany(CoachingMeeting::class);
    }

}
