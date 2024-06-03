<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    /**
     * The storage path which used to store files of the user on it
     */
    public static $storagePath = 'galleries';

    protected $guarded = [];

    protected function getImageUrlAttribute(): string|null
    {
        return $this->image ? asset('public/' . Storage::url(self::$storagePath . '/' . $this->image)) : null;
    }
}
