<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nights', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('game_id');
            $table->integer('night');
            $table->unsignedInteger('action_id');
            $table->unsignedInteger('target_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nights');
    }
}
