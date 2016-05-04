<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\PlayerContext;

class PlayerContextServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton( "App\Http\Controllers\PlayerContext", function() {
           return new PlayerContext();
        });
    }

    public function register() { }
}
