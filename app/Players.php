<?php

namespace App;

use App\Http\Controllers\PlayerContext;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Players extends Model
{
    protected $table = 'Players';
    protected $primaryKey = 'player_id';

    public $timestamps = true;

    public static function createPlayer(Request $request)
    {
        $player = new Players();

        $player->player_key = uniqid();
        $player->username = $request->input('username', 'null');
        $player->email = $request->input('email', 'null');
        $player->pic = 'pic';
        $player->device = 'phone';
        $player->save();

        return $player;
    }
    
    public function clearCurrentGame(PlayerContext $player)
    {
        $player =  self::where('player_key', $player->getPlayerKey())
            ->first();

        $player->CurrentGame = null;
        $player->save();
    }

    public function setCurrentGame($lobbyId, $playerKey)
    {
        $player =  self::where('player_key', $playerKey)
            ->first();

        $player->CurrentGame = $lobbyId;

        $player->save();
    }



    //
}
