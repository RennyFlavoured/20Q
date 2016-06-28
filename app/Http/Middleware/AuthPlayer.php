<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use App\Http\Controllers\PlayerContext;

use App\Players;
use App\LobbyLive;

use Closure;
use Response;

class AuthPlayer
{
    /** @var PlayerContext */
    private $playerContext;

    const PLAYER_ID_HEADER = "playerKey";

    public function __construct( PlayerContext $playerContext )
    {
        $this->playerContext = $playerContext;
    }

    public function handle(Request $request, Closure $next)
    {
        $key = $request->header( self::PLAYER_ID_HEADER );

        if ( empty( $key ) )
        {
            return Response::json( [
                'exception' => 'No Key Provided',
            ], 403 );
        }

        $user = $this->getUser($key);

        $this->playerContext->PlayerContext($user);

        return $next($request);
    }

    private function getUser($key)
    {
        $player = Players::where('player_key', $key)
            ->first();

        if (!$player) {
            return Response::json([
                'exception' => 'No Match for playerKey, player does not exist',
            ], 403);
        }

        return $player;
    }

//    private function checkExpiredGame($user)
//    {
//
//        $player->CurrentGame = null;
//        $player->save();
//    }
//
//    private function getCurrentGame($user)
//    {
//        $lobby = LobbyLive::where('LobbyId', $user->CurrentGame)
//            ->first();
//
//        $player->CurrentGame = null;
//        $player->save();
//    }
}