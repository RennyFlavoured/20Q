<?php

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
        Schema::create('Players', function (Blueprint $table) {
            $table->increments('player_id');
            $table->string('player_key')->unique();
            $table->string('username');
            $table->string('email');
            $table->string('CurrentGame');
            $table->string('pic');
            $table->string('device');
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
        Schema::drop('Players');
    }
}
