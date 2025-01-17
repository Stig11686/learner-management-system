<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    protected $fillable = ['name', 'course_id'];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function lessons(){
        return $this->belongsToMany(Lesson::class)->withPivot('date')->orderBy('pivot_date', 'asc');
    }

    public function learners(){
        return $this->hasMany(Learner::class);
    }


}
