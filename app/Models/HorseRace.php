<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorseRace extends Model
{
    protected $fillable = ['horse_id', 'race_id', 'time'];
}
