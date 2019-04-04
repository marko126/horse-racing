<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Race extends Model
{
    const LENGTH = 1500;
    
    public function horses() {
        return $this->belongsToMany(\App\Models\Horse::class, 'horse_races', 'race_id', 'horse_id');
    }
    
    /**
     * @return float
     */
    public function getCurrentTime() {
        $startedTime = strtotime($this->started_at);
        $currentTime = strtotime("now");
        
        return $currentTime - $startedTime;
    }
    
    /**
     * @return type
     */
    public static function getBestResultHtml() {
        
        $bestResultTime = DB::table('horse_races')
                ->orderBy('time')
                ->limit(1)
                ->pluck('time')
                ->toArray();
        
        $bestResults = DB::table('horse_races')
                ->leftJoin('horses', 'horses.id', '=', 'horse_races.horse_id')
                ->where('horse_races.time', '=', $bestResultTime[0])
                ->groupBy('horses.name')
                ->pluck('name')
                ->toArray();
        
        return '
            <div class="col-sm-12">
                <div>Time: ' . $bestResultTime[0] . '</div>
                <div>' . (count($bestResults) > 1 ? 'Horses: ' : 'Horse: ') . implode(', ', $bestResults) . '</div>
            </div>
        ';
    }
    
    /**
     * @return array
     */
    public function getPositions() {
        
        $horces = $this->horses()->orderBy('horse_races.time')
                ->pluck('horses.id')
                ->toArray();
        
        return array_flip($horces);
        
    }
}
