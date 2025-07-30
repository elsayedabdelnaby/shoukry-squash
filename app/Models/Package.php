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

    protected $fillable = [
        'name',
        'breif',
        'sessions_per_week',
        'price_egyptian',
        'price_other',
        'type',
        'one_month_price',
        'image_card',
        'min_age',
        'max_age',
    ];

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

    /**
     * Check if a player is eligible for this package based on age
     */
    public function isEligibleForPlayer($player): bool
    {
        if (!$player->age) {
            return false;
        }

        $playerAge = $player->age;

        // Check minimum age
        if ($this->min_age && $playerAge < $this->min_age) {
            return false;
        }

        // Check maximum age
        if ($this->max_age && $playerAge > $this->max_age) {
            return false;
        }

        return true;
    }

    /**
     * Get age range display string
     */
    public function getAgeRangeAttribute(): string
    {
        if ($this->min_age && $this->max_age) {
            return "{$this->min_age} - {$this->max_age} years";
        } elseif ($this->min_age) {
            return "{$this->min_age}+ years";
        } elseif ($this->max_age) {
            return "Up to {$this->max_age} years";
        }
        return "All ages";
    }

    /**
     * Get age restriction message for a player
     */
    public function getAgeRestrictionMessage($player): string
    {
        if (!$player->age) {
            return "Player age is required to check eligibility.";
        }

        $playerAge = $player->age;

        if ($this->min_age && $playerAge < $this->min_age) {
            return "Player must be at least {$this->min_age} years old. Current age: {$playerAge} years.";
        }

        if ($this->max_age && $playerAge > $this->max_age) {
            return "Player must be {$this->max_age} years old or younger. Current age: {$playerAge} years.";
        }

        return "Player is eligible for this package.";
    }

    /**
     * Get price based on player nationality
     */
    public function getPriceForNationality($nationality): float
    {
        return $nationality === 'Egyptian' ? $this->price_egyptian : $this->price_other;
    }
}
