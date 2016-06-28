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
    const TIMEOUT = 32;

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

        $currDateTime = new Carbon();
        $currDateTime->addSeconds(self::TIMEOUT);

        $lobby->Key = uniqid('20q_');
        $lobby->PlayerList = json_encode([$player]);
        $lobby->QuestionList = json_encode($Qs);
        $lobby->PlayerCount = 1;
        $lobby->Live = false;
        $lobby->StartDate = $currDateTime;
        $lobby->save();

        return $lobby;
    }

    public function findLobby($playerKey)
    {
        return $this->findOpen($playerKey);
    }

    public function findCurrent($gameId){
        $lobby = self::where('LobbyId', $gameId)
            ->first();

        $this->readyCheck($lobby);

        return $lobby;
    }

    public function timeRemaining($created)
    {
        return ;
    }

    private function findOpen($playerKey)
    {
        $players = new Players();
        $lobbyResult = self::where('Live', false)
            ->first();

        if($lobbyResult){

            $lobbyUpdate = $this->setLobbyCounters($lobbyResult,$playerKey);
            $players->setCurrentGame($lobbyUpdate->LobbyId, $playerKey);

            $this->readyCheck($lobbyUpdate);

            return $lobbyUpdate;
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
        $isLive = $this->liveCheck($lobby);

        if($isLive || ($lobby->PlayerCount == self::MAX_PLAYERS)){
            $this->addBots($lobby);

            $lobby->Live = true;
            $lobby->save();
        }
    }

    private function addBots($lobby)
    {
        $playerList = json_decode($lobby->PlayerList, true);
        $delta = (20 - (count($playerList)));

        if($delta > 0){
            for ($k = 0 ; $k < $delta; $k++){
                $playerList[] = 'bot_' . $k;
            }
        }

        $lobby->PlayerList = json_encode($playerList);
        $lobby->save();

        return $lobby;
    }

    public function liveCheck($lobby)
    {
        $compareDate = new Carbon($lobby->StartDate);

        $check = $compareDate->lte(new Carbon());
        return $check;
    }
}
