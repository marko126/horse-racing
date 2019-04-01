<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public function horse() {
        return $this->belongsToMany(\App\Models\Horse::class, 'horse_races', 'race_id', 'horse_id');
    }
}
