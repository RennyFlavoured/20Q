<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;

use App\LobbyLive;

class LobbyController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function findLobby(Request $request)
    {
        $this->validate( $request, [
            'PlayerKey'    => 'required|string'
        ]);

        $lobbyConfig = new LobbyLive();
        $lobby = $lobbyConfig->findLobby($request->get('PlayerKey'));


        return $lobby;
    }

}
