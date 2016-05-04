<?php

namespace App\Http\Controllers;

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
        $lobby = $lobbyConfig->findLobby($this->playerContext->getPlayerKey());


        return $lobby;
    }

}
