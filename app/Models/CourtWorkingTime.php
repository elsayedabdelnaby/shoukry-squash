<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtWorkingTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'week_day',
        'start_time',
        'end_time',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
