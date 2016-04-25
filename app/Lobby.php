<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lobby extends Model
{
    protected $table = 'Lobby';
    protected $primaryKey = 'lobby_id';

    public $timestamps = true;

    const MAX_PLAYERS = 20;

    public static function createLobby()
    {
        $lobby = new Lobby();

        $lobby->key = uniqid('20q_');
        $lobby->current_players = 0;
        $lobby->max_players = self::MAX_PLAYERS;
        $lobby->save();

        return $lobby;
    }



    //
}
