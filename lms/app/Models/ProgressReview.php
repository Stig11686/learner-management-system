<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressReview extends Model
{
    public function learner() {
        return $this->belongsTo(Learner::class);
    }
}
