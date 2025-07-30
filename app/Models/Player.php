<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Player extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'players';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'phone',
        'birth_date',
        'nationality',
        'gender',
        'parents_contact_number',
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        return $this->birth_date ? \Carbon\Carbon::parse($this->birth_date)->age : null;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    // Relationships
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }

    public function hasActiveSubscription()
    {
        return $this->subscriptions()->where('status', 'active')->exists();
    }

    public function getWeeklySessionCount($packageId, $date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();
        $weekStart = $date->copy()->startOfWeek();
        $weekEnd = $date->copy()->endOfWeek();
        
        return \App\Models\Reservation::where('player_id', $this->id)
            ->where('package_id', $packageId)
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->count();
    }

    public function canBookSession($packageId, $date = null)
    {
        $activeSubscription = $this->subscriptions()
            ->where('package_id', $packageId)
            ->where('status', 'active')
            ->where('start_date', '<=', $date ?? Carbon::now())
            ->where('end_date', '>=', $date ?? Carbon::now())
            ->first();

        if (!$activeSubscription) {
            return false;
        }

        $weeklyCount = $this->getWeeklySessionCount($packageId, $date);
        $package = \App\Models\Package::find($packageId);
        
        return $weeklyCount < $package->sessions_per_week;
    }
}
