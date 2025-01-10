<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachingMeeting extends Model
{
    public function learner() {
        return $this->belongsTo(Learner::class);
    }
}
