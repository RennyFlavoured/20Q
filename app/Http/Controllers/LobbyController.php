<?php

namespace App\Http\Controllers;

use App\Players;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;

use App\Http\Controllers\PlayerContext;

use App\LobbyLive;

class LobbyController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /** @var playerContext */
    private $playerContext;

    public function __construct(PlayerContext $playerContext)
    {
        $this->playerContext = $playerContext;
    }

    public function findLobby()
    {
        $lobbyConfig = new LobbyLive();
        $player = new Players();

        if($this->playerContext->getCurrentGame()) {
            $lobby = $lobbyConfig->findCurrent($this->playerContext->getCurrentGame());
        } else {
            $lobby = $lobbyConfig->findLobby($this->playerContext->getPlayerKey());
        }

        if($lobbyConfig->timeRemaining($lobby->created_at) > 50){
            $player->clearCurrentGame($this->playerContext);
        }
        
        $format = [
            'lobbyId'       => $lobby->LobbyId,
            'playerList'    => $lobby->PlayerList,
            'questionList'  => $lobby->QuestionList,
            'playerCount'   => $lobby->PlayerCount,
            'live'          => $lobby->Live,
            'createdAt'     => $lobby->created_at->toDateTimeString(),
            'startDate'     => $lobby->StartDate->toDateTimeString()
        ];


        return $format;
    }

}
