<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 03.08.2020
 * Time: 20:51
 */

namespace Controllers;

use View\View;
use Models\Times\Time;
use Models\UserTimeGames\UserTimeGame;

class FastDigitController extends AbstractController
{
    protected $view;

    public function main()
    {
        $this->view->renderHtml('games/script.php');
    }

    public function saveTime($time, $id_user)
    {
        Time::saveTime($time);
        UserTimeGame::saveUserTimeGame($id_user, $time, 1);
    }

    public function findTime($user_id)
    {
       return UserTimeGame::findOneByColumn("user_id", $user_id);
    }

    public function findAllTime()
    {
        $UserTimeGames = new UserTimeGame();
        return $UserTimeGames->getAllTime();
    }


}