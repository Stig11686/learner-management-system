<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function cohorts(){
        return this->hasMany(Cohort::class);
    }
}
