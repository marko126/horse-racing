<?php

use Illuminate\Database\Seeder;
use App\Models\Horse;

class HorsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 50; $i ++) {
            Horse::create([
                'name'      => $faker->name,
                'speed'     => mt_rand(0, 100)/10,
                'strength'  => mt_rand(0, 100)/10,
                'endurance' => mt_rand(0, 100)/10
            ]);
        }
    }
}
