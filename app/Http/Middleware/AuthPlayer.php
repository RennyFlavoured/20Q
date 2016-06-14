<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use App\Http\Controllers\PlayerContext;

use App\Players;

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

        $player = Players::where('player_key', $key)
            ->first();

        if ( !$player )
        {
            return Response::json( [
                'exception' => 'No Match for PlayerKey, player does not exist',
            ], 403 );
        }

        $this->playerContext->PlayerContext($player);

        return $next($request);
    }
}