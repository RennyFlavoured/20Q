<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use App\Players;

use Closure;
use Response;

class AuthPlayer
{
    public function handle(Request $request, Closure $next)
    {
        $key = $request->get('PlayerKey');

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

        return $next($request);
    }
}