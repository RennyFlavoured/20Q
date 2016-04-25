<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LobbyParticipants extends Model
{
    protected $table = 'LobbyParticipants';
    protected $primaryKey = 'lobby_p_id';

    public $timestamps = true;
}
