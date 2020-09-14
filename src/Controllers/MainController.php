<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 18.06.2020
 * Time: 17:32
 */

namespace Controllers;

use View\View;
use Services\Db;

use Models\Times\Time;
use Models\Users\User;

class MainController
{

    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../templates');
    }

    public function main()
    {
        $result = User::findAll();

        if ($result === []) {
            // Здесь обрабатываем ошибку
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('main.php', ['result' => $result]);
    }

    public function sayHello($name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name]);
    }
}