<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horse extends Model
{
    const BASE_SPEED = 5;
    const STRENGTH_INDEX = 8;
    
    protected $fillable = ['name', 'speed', 'strength', 'endurance'];
    
    public function race() {
        return $this->belongsToMany(\App\Models\Race::class, 'horse_races', 'horse_id', 'race_id');
    }
    
    /**
     * @param float $value
     */
    public function setSpeedAttribute($value) {
        if ($value < 0) {
            $this->attributes['speed'] = 0.0;
        } else if ($value > 10) {
            $this->attributes['speed'] = 10.0;
        } else {
            $this->attributes['speed'] = number_format($value, 1);
        }
    }

    /**
     * @param float $value
     */
    public function setStrengthAttribute($value) {
        if ($value < 0) {
            $this->attributes['strength'] = 0.0;
        } else if ($value > 10) {
            $this->attributes['strength'] = 10.0;
        } else {
            $this->attributes['strength'] = number_format($value, 1);
        }
    }

    /**
     * @param float $value
     */
    public function setEnduranceAttribute($value) {
        if ($value < 0) {
            $this->attributes['endurance'] = 0.0;
        } else if ($value > 10) {
            $this->attributes['endurance'] = 10.0;
        } else {
            $this->attributes['endurance'] = number_format($value, 1);
        }
    }
    
    /**
     * @return float
     */
    public function getMaxSpeed(): float {
        return number_format(self::BASE_SPEED + $this->attributes['speed'], 1);
    }
    
    /**
     * @return float
     */
    public function getReducedSpeed(): float {
        return number_format($this->getMaxSpeed() - self::BASE_SPEED * (100 - self::STRENGTH_INDEX * $this->attributes['strength']) / 100, 1);
    }
    
    /**
     * @return float
     */
    public function getMaxSpeedTime() {
        return ($this->attributes['endurance'] * 100 / $this->getMaxSpeed());
    }
    
    /**
     * @return float
     */
    public function getReducedSpeedTime(int $length = 1500) {
        return (($length - $this->attributes['endurance'] * 100) / $this->getReducedSpeed());
    }
    
    public function getTime(int $length = 1500) {
        
        $totalTime = $this->getMaxSpeedTime() + $this->getReducedSpeedTime($length);
        
        return $totalTime;
    }
}
