<?php

namespace App;

use App\Http\Controllers\PlayerContext;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Round extends Model
{
    protected $table = 'Round';
    protected $primaryKey = 'RoundInc';

    public $timestamps = true;

    const IN_PROGRESS = 1;
    const CLOSED = 0;

    const TIMEOUT = 32;

    public static function createRound($lobbyId, $roundId)
    {
        $round = new Round();

        $currDateTime = new Carbon();
        $currDateTime->addSeconds(self::TIMEOUT);

        $round->LobbyId = $lobbyId;
        $round->RoundId = $roundId;
        $round->QuestionId = '';
        $round->Answers = json_encode([]);
        $round->Lives = json_encode([]);
        $round->Status = self::IN_PROGRESS;
        $round->FinishDate = $currDateTime;
        $round->save();

        return $round;
    }

    public static function getCurrentRoundDetails($roundId, $lobbyId)
    {
        return self::where('RoundId', $roundId)
            ->where('LobbyId', $lobbyId)
            ->first();
    }



    //
}
