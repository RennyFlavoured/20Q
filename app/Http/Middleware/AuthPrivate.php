<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;

class AuthPrivate
{
    const PRIVATE_TOKEN_HEADER = "secret";

    public function handle(Request $request, Closure $next)
    {
        $privateKey = config( 'app.secret' );

        if ( empty( $privateKey ) )
        {
            abort( 403, "Unauthorized" );
        }

        if ( $request->header( self::PRIVATE_TOKEN_HEADER ) != $privateKey )
        {
            abort( 403, "Unauthorized" );
        }

        return $next($request);
    }
}