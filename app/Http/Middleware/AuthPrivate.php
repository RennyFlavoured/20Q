<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use App\Exceptions\Fatal\ConfigException;

use Closure;

class AuthPrivate
{
    const PRIVATE_TOKEN_HEADER = "Token";

    public function handle(Request $request, Closure $next)
    {
        $privateKey = config( 'app.accessSecret' );
        if ( empty( $privateKey ) )
        {
            throw ConfigException::PrivateKeyNotConfigured();
        }

        if ( $request->header( self::PRIVATE_TOKEN_HEADER ) != $privateKey )
        {
            abort( 403, "Unauthorized" );
        }

        return $next($request);
    }
}