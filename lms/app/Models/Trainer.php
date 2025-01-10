<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function learners()
    {
        return $this->hasMany(Learner::class, 'trainer_id');
    }

}
