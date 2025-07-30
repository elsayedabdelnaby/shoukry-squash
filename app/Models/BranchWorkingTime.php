<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchWorkingTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'week_day',
        'start_time',
        'end_time',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
