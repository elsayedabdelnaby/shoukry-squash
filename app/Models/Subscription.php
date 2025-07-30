<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'player_id',
        'package_id',
        'branch_id',
        'start_date',
        'end_date',
        'price_paid',
        'payment_method',
        'payment_document',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price_paid' => 'decimal:2',
    ];

    // Relationships
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && 
               $this->start_date <= Carbon::today() && 
               $this->end_date >= Carbon::today();
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date < Carbon::today();
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->isExpired) {
            return 0;
        }
        return Carbon::today()->diffInDays($this->end_date, false);
    }

    public function getDurationInDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    // Methods
    public function updateStatus()
    {
        if ($this->end_date < Carbon::today() && $this->status === 'active') {
            $this->update(['status' => 'expired']);
        }
    }

    public function getPriceForNationality()
    {
        return $this->player->nationality === 'Egyptian' 
            ? $this->package->price_egyptian 
            : $this->package->price_other;
    }

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
