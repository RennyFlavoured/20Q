<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLobbyLiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LobbyLive', function (Blueprint $table) {
            $table->increments('LobbyId');
            $table->string('Key')->unique();
            $table->string('PlayerList');
            $table->string('QuestionList');
            $table->integer('PlayerCount');
            $table->boolean('Live');
            $table->string('StartDate');
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
        Schema::drop('LobbyLive');
    }
}
