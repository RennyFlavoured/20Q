<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Round', function (Blueprint $table) {
            $table->increments('RoundInc');
            $table->integer('LobbyId');
            $table->integer('RoundId');
            $table->integer('QuestionId');
            $table->string('Answers');
            $table->string('Lives');
            $table->boolean('Status');
            $table->string('FinishDate');
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
        Schema::drop('Round');
    }
}
