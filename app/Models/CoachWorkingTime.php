<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachWorkingTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id', 'branch_id', 'week_day', 'start_time', 'end_time',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
