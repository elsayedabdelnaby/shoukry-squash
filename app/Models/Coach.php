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


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function schedules()
    {
        return $this->hasMany(CoachSchedule::class, 'coach_id');
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
