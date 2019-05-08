<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->integer('id', false, true)->unique();
            $table->timestamps();
            $table->string('name');
//            $table->dateTime('inGameRegister');
//            $table->dateTime('lastLogin');
            $table->integer('hoursPlayed');
            $table->integer('level');
            $table->integer('losses');
            $table->integer('wins');
            $table->integer('leaves');
            $table->string('region');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
