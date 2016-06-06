<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

use App\Players;

class PlayerContext {

    /** @var player_key **/
    private $player_key;

    /** @var username **/
    private $username;

    /** @var email **/
    private $email;

    /** @var current_game **/
    private $current_game;

    /** @var pic **/
    private $pic;

    /** @var device **/
    private $device;

    public function getPlayerKey()
    {
        return $this->player_key;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCurrentGame()
    {
        return $this->current_game;
    }

    public function getPic()
    {
        return $this->pic;
    }

    public function getDevice()
    {
        return $this->device;
    }

    public function PlayerContext( Players $player )
    {
        $this->player_key = $player->player_key;
        $this->username = $player->username;
        $this->email = $player->email;
        $this->current_game = $player->CurrentGame;
        $this->pic = $player->pic;
        $this->device = $player->device;
    }

    public function clearUser()
    {
        $this->realm = '';
        $this->userAgent = '';
        $this->ip = '';
        $this->user = '';
    }
}