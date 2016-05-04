<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Http\Controllers\PlayerContext;

use Illuminate\Http\Request;
use App\Players;

class PlayerController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function createPlayer(Request $request)
    {
        $this->validate( $request, [
            'Username'    => 'string',
            'Email'       => 'string'
        ]);

        $player = Players::createPlayer($request);

        $return  = [
            'PlayerKey'     => $player->player_key,
            'Username'      => $player->username,
            'Email'         => $player->email
        ];

        return $return;
    }

}
