<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Lobby;

class LobbyController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function findLobby()
    {
        $lobby = Lobby::where('current_players', '<', 20)
            ->first();

        if(!$lobby){
            $lobby = Lobby::createLobby();
        }

        $return  = [
            'lobby_key'     => $lobby->key,
            'lobby_members' => $lobby->current_players
        ];

        return $return;
    }

}
