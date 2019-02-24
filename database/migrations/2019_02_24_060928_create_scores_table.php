<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('match_id');
            $table->foreign('match_id')->references('id')->on('matches');
            $table->string('batting_team');
            $table->integer('over_number');
            $table->string('batsmen');
            $table->string('bowler');
            $table->integer('runs_scored')->default(0);
            $table->integer('wickets_fallen')->default(0);
            $table->integer('total_runs_till_this_over')->default(0);
            $table->integer('total_wickets_till_this_over')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
