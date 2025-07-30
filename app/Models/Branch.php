<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'branches';

    /**
     * The storage path which used to store files of the user on it
     */
    public static $storagePath = 'branches';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'address',
        'location',
        'starting_at',
        'ending_at',
        'number_of_courts',
        'working_days',
        'image',
    ];

    protected $casts = [
        'working_days' => 'array',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->dontSubmitEmptyLogs();
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

    public function courts()
    {
        return $this->hasMany(Court::class);
    }

    public function coaches()
    {
        return $this->hasManyThrough(Coach::class, CoachWorkingTime::class, 'branch_id', 'id', 'id', 'coach_id');
    }
}
