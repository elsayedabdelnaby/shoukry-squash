<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'packages';

    protected $guarded = [];

    /**
     * The storage path which used to store files of the user on it
     */
    public static $storagePath = 'packages';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    /**
     * return the image profile's url of the user.
     *
     * @return string|null
     */
    protected function getImageCardUrlAttribute(): string|null
    {
        return $this->image_card ? asset('public/' . Storage::url(self::$storagePath . '/' . $this->image_card)) : null;
    }
}
