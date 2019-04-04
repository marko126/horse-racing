<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;
use Illuminate\Support\Facades\DB;
use App\Models\HorseRace;
use App\Models\Horse;

class RaceController extends Controller {

    public function create() {
        $activeRaces = Race::where('ended_at', '>', date('Y-m-d H:i:s', strtotime('now')))->get();

        if ($activeRaces->count() > 2) {
            return response()->json(['status' => 'error']);
        }

        // We must use transaction to ensure that all models will be stored correctly
        DB::beginTransaction();

        try {
            // Let's first create new race
            $race = new Race();
            $race->started_at = date('Y-m-d H:i:s', strtotime('now'));
            $race->length = Race::LENGTH;
            $race->save();

            // Get horses that do compete in any active race
            $horsesInRace = DB::table('horses')
                    ->leftJoin('horse_races', 'horse_races.horse_id', '=', 'horses.id')
                    ->leftJoin('races', 'races.id', '=', 'horse_races.race_id')
                    ->whereNull('races.ended_at')
                    ->orWhere('races.ended_at', '>', date('Y-m-d H:i:s', strtotime('now')))
                    ->groupBy('horses.id')
                    ->pluck('horses.id')
                    ->toArray();

            $horsesNotInRace = Horse::whereNotIn('id', $horsesInRace)->pluck('id')->toArray();

            // Choose 8 random horses 
            $random_keys = array_rand($horsesNotInRace, 8);

            // Assign random horse to the race
            $maxTime = 0;
            foreach ($random_keys as $key) {
                $horse = Horse::find($horsesNotInRace[$key]);
                HorseRace::create([
                    'horse_id' => $horse->id,
                    'race_id' => $race->id,
                    'time' => $horse->getTime($race->length)
                ]);
                $maxTime = $maxTime < $horse->getTime($race->length) ? $horse->getTime($race->length) : $maxTime;
            }

            $race->ended_at = date('Y-m-d H:i:s', strtotime($race->started_at) + $maxTime);
            $race->save();

            DB::commit();

            return response()->json(['status' => 'ok']);
        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json(['status' => 'error']);
        }
    }

    public function getActiveRaces() {
        $activeRaces = Race::where('ended_at', '>', date('Y-m-d H:i:s', strtotime('now')))->get();

        $data = [];

        foreach ($activeRaces as $key => $race) {
            $data[$key] = [
                'raceId'        => $race->id,
                'length'        => $race->length,
                'currentTime'   => $race->getCurrentTime(),
                'horses'        => []
            ];
            $positions = $race->getPositions();
            foreach ($race->horses as $horse) {
                $data[$key]['horses'][] = [
                    'horseId'               => $horse->id,
                    'horseName'             => $horse->name,
                    'horseMaxSpeed'         => $horse->getMaxSpeed(),
                    'horseReducedSpeed'     => $horse->getReducedSpeed(),
                    'horseEndurance'        => number_format($horse->endurance, 1),
                    'horseCurrentLength'    => $horse->getCurrentLength($race->getCurrentTime(), $race->length),
                    'horseFinalTime'        => $horse->getTime(),
                    'horsePosition'         => $positions[$horse->id] + 1
                ];
            }
        }

        return response()->json($data);
    }

    public function getActiveRacesHtml() {
        $activeRaces = Race::where('ended_at', '>', date('Y-m-d H:i:s', strtotime('now')))->get();

        $html = '';

        foreach ($activeRaces as $race) {

            ob_start();
            ?>

            <div class="race" id="race-<?= $race->id ?>">
                <h3 class="title-divider">
                    <span>Race #<?= $race->id ?></span>
                </h3>
                <div class="row">
                    <div class="col-sm-12">
                        <table>
                            <thead>
                                <tr>
                                    <th class="horse-id">#</th>
                                    <th class="horse-name">Horse</th>
                                    <th class="horse-dist">Distance (m)</th>
                                    <th class="horse-time">Time (s)</th>
                                    <th class="horse-pos">Position</th>
                                    <th class="horse-progress">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($race->horses as $key => $horse): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $horse->name ?></td>
                                        <td id="dist<?= $horse->id ?>"><?= (int) $horse->getCurrentLength($race->getCurrentTime(), $race->length) ?></td>
                                        <td id="time<?= $horse->id ?>"><?= ($horse->getCurrentLength($race->getCurrentTime(), $race->length) / $race->length) >= 1 ? number_format($horse->getTime(), 2) : '' ?></td>
                                        <td id="pos<?= $horse->id ?>"><?= ($horse->getCurrentLength($race->getCurrentTime(), $race->length) / $race->length) >= 1 ? $race->getPositions()[$horse->id] : '' ?></td>
                                        <td>
                                            <div id="myProgress<?= $key + 1 ?>" class="myProgress">
                                                <div id="myBar<?= $horse->id ?>" 
                                                     class="myBar myBar<?= $key + 1 ?>" 
                                                     style="width: <?= $horse->getCurrentLength($race->getCurrentTime(), $race->length) * 100 / $race->length . '%' ?>"
                                                     ></div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr />

            <?php
            $html .= ob_get_clean();
        }

        return $html;
    }

    public function getLastResultsHtml(int $number = 5) {
        $races = Race::where('ended_at', '<', date('Y-m-d H:i:s', strtotime('now')))
                ->orderBy('ended_at', 'desc')
                ->limit($number)
                ->get();

        $html = '';

        foreach ($races as $race) {

            ob_start();
            ?>

            <div class="col-sm-4 last-race">
                <table>
                    <thead>
                        <tr>
                            <th class="last-horse-id">#</th>
                            <th class="last-horse-name">Horse</th>
                            <th class="last-horse-time">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $horses = $race->horses()
                                ->orderBy('horse_races.time')
                                ->take(3)
                                ->get();
                        foreach ($horses as $key => $horse): 
                        ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $horse->name ?></td>
                                <td><?= number_format($horse->getTime(), 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>        

            <?php
            $html .= ob_get_clean();
        }
        
        return $html;
    }
    
    public function getBestResultHtml() {
        
        Race::getBestResultHtml();
    }

}
