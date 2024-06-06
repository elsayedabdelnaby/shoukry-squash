<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Press extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $table = 'press';

    /**
     * The storage path which used to store files of the user on it
     */
    public static $storagePath = 'press';

    protected $guarded = [];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function posters()
    {
        return $this->hasMany(PressPoster::class, 'press_id');
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

    /**
     * return the image profile's url of the user.
     *
     * @return string|null
     */
    protected function getMainImageUrlAttribute(): string|null
    {
        return $this->main_image ? asset('public/' . Storage::url(self::$storagePath . '/' . $this->main_image)) : null;
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
}
