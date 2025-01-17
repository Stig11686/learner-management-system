<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;



class OTJLog extends Model
{
    protected $table = 'otj_hours';

    protected $fillable = ['learner_id', 'date', 'hours', 'activity_description', 'comments', 'evidence_link', 'learning_type', 'status', 'evidence_link'];

    public static function getEnumValues($table, $column)
    {
        $query = "SHOW COLUMNS FROM `{$table}` WHERE Field = ?";
        $result = DB::select($query, [$column]);

        if (isset($result[0])) {
            $type = $result[0]->Type;

            preg_match('/^enum\((.*)\)$/', $type, $matches);

            return array_map(function ($value) {
                return trim($value, "'");
            }, explode(',', $matches[1]));
        }

        return [];
    }

    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

}
