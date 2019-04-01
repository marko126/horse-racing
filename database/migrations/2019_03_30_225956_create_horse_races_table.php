<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorseRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horse_races', function (Blueprint $table) {
            $table->integer('horse_id');
            $table->integer('race_id');
            $table->decimal('time', 10, 2);
            $table->timestamps();
            $table->primary(['horse_id', 'race_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horse_races');
    }
}
