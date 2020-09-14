<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 08.06.2020
 * Time: 15:43
 */

namespace Models\Games;

class Game
{
    private $game;

    public function __construct($game)
    {
        $this->game = $game;
    }

    public function getGame()
    {
        return $this->game;
    }

}