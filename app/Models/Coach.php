<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Coach extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'coaches';

    /**
     * The storage path which used to store files of the user on it
     */
    public static $storagePath = 'coaches';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'title',
        'level',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'brief',
        'is_active',
        'image',
        'cost_per_hour',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function schedules()
    {
        return $this->hasMany(CoachSchedule::class, 'coach_id');
    }

    public function workingTimes()
    {
        return $this->hasMany(CoachWorkingTime::class, 'coach_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'coach_id');
    }

    public function getWorkingTimesByDay($weekDay)
    {
        return $this->workingTimes()->where('week_day', $weekDay)->orderBy('start_time')->get();
    }

    public function getWorkingTimesByDayAndBranch($weekDay, $branchId = null)
    {
        $query = $this->workingTimes()->where('week_day', $weekDay);
        
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }
        
        return $query->orderBy('start_time')->get();
    }

    public function hasTimeConflict($weekDay, $startTime, $endTime, $excludeId = null, $branchId = null)
    {
        $query = $this->workingTimes()
            ->where('week_day', $weekDay)
            ->where(function($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            });

        // Only filter by branch if specifically requested (for future flexibility)
        // By default, we check across all branches to prevent physical impossibility
        if ($branchId !== null) {
            $query->where('branch_id', $branchId);
        }

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * return the image profile's url of the user.
     *
     * @return string|null
     */
    protected function getImageUrlAttribute(): string|null
    {
        return $this->image ? asset('public/' . Storage::url(self::$storagePath . '/' . $this->image)) : null;
    }
}
