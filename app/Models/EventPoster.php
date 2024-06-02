<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventPoster extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_posters';

    /**
     * The storage path of the model.
     *
     * @var string
     */
    static $storagePath = 'events';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'poster',
        'event_id',
    ];


    /**
     * get the merchant Event of the poster
     */
    public function Event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * Interact with the card's poster url.
     *
     * @return string
     */
    public function getPosterURLAttribute()
    {
        return $this->poster ? asset('public/' . Storage::url(self::$storagePath . '/' . $this->poster)) : null;
    }
}
