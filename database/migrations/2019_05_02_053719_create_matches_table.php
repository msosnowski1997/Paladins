<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->integer('id', false, true)->unique();
            $table->timestamps();
            $table->integer('player1_1');
            $table->integer('player1_2');
            $table->integer('player1_3');
            $table->integer('player1_4');
            $table->integer('player1_5');
            $table->integer('player2_1');
            $table->integer('player2_2');
            $table->integer('player2_3');
            $table->integer('player2_4');
            $table->integer('player2_5');
            $table->text('player1_1_info');
            $table->text('player1_2_info');
            $table->text('player1_3_info');
            $table->text('player1_4_info');
            $table->text('player1_5_info');
            $table->text('player2_1_info');
            $table->text('player2_2_info');
            $table->text('player2_3_info');
            $table->text('player2_4_info');
            $table->text('player2_5_info');
            $table->dateTime('entryTime');
            $table->text('matchInfo');
            $table->string('map');
            $table->integer('queue_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
