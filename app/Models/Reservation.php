<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'coach_id',
        'court_id',
        'branch_id',
        'package_id',
        'type',
        'date',
        'start_time',
        'end_time',
        'duration_minutes',
        'price',
        'payment_method',
        'payment_document',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
