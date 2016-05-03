<?php

namespace App;

use App\Players;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class LobbyLive extends Model
{
    protected $table = 'LobbyLive';
    protected $primaryKey = 'LobbyId';

    public $timestamps = true;

    const MAX_PLAYERS = 20;

    public static function generateQuestions()
    {
        $numbers = range(1, 5);
        shuffle($numbers);

        $range = [];

        foreach($numbers as $number){
            $subNumbers = range(1, 5);
            shuffle($subNumbers);

            $range[$number] = array_values($subNumbers);
        }

        return $range;
    }

    public static function createLobby($player)
    {
        $lobby = new LobbyLive();

        $Qs = self::generateQuestions();

        $lobby->Key = uniqid('20q_');
        $lobby->PlayerList = json_encode([$player]);
        $lobby->QuestionList = json_encode($Qs);
        $lobby->PlayerCount = 1;
        $lobby->Live = false;
        $lobby->save();

        return $lobby;
    }

    public function findLobby($playerKey)
    {
        $lobbyExists = $this->findOpen($playerKey);

        return $lobbyExists;
    }

    private function findOpen($playerKey)
    {
        $players = new Players();
//        $lobbyResult = false;
        $lobbyResult = self::where('Live', false)
            ->first();


        if($lobbyResult){

            $lobbyUpdate = $this->setLobbyCounters($lobbyResult,$playerKey);
            $players->setCurrentGame($lobbyUpdate->LobbyId, $playerKey);

            $start = $lobbyUpdate->created_at;
            $diff = $start->diffInSeconds(Carbon::now());
//            set a context object for this!
            $ready = $this->readyCheck($lobbyUpdate);

            return [$lobbyUpdate, $diff];
        }

        return self::createLobby($playerKey);
    }

    private function setLobbyCounters($lobby, $playerKey)
    {
        $playerList = json_decode($lobby->PlayerList, true);
        $playerList[] = $playerKey;

        $lobby->PlayerList = json_encode($playerList);
        $lobby->PlayerCount++;
        $lobby->save();

        return $lobby;
    }

    private function readyCheck($lobby)
    {
        $start = $lobby->created_at;

        $diff = $start->diffInSeconds(Carbon::now());

        if($lobby->PlayerCount == self::MAX_PLAYERS){
            $lobby->Live = true;
            $lobby->save();

            return true;
        }

        return false;
    }



    //
}
