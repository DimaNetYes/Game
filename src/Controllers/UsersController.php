<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 30.06.2020
 * Time: 14:33
 */

namespace Controllers;

use Exceptions\InvalidArgumentException;
use View\View;
use Models\Users\User;
use Models\Users\UserActivationService;
use Services\EmailSender;
use Services\UsersAuthService;

class UsersController extends AbstractController
{
    protected $view;

    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                //Создание токена (cookie)
                UsersAuthService::createToken($user); //Установка "Токенной" Куки
                header('Location: /www/users/main');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('signUp/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('main.php');
    }

    public function signUp()
    {
        if(!empty($_POST)){
            try {
                $user = User::signUp($_POST);
                UsersAuthService::createToken($user);
            }catch (InvalidArgumentException $e){
                $this->view->renderHtml('signUp/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
                    //авторизация по email
            if($user instanceof User){
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('signUp/signUpSuccesfull.php', [], '200');
                return;
            }
        }

        $this->view->renderHtml("signUp/signUp.php", [], "200");
    }

    public function main()
    {
//        $this->view->renderHtml('main.php', ['user' => UsersAuthService::getUserByToken()], '200'); //В construct другой подход setVar()
        $this->view->renderHtml('main.php', [], '200');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
//            $this->view->renderHtml("main.php", [], "200");
            header('Location: /www/users/main');
//            exit();
        }
    }

    public function out()
    {
        setcookie('token', '', time()-3600, '/', '', false, true);
//        $this->view->renderHTML("main.php", [], 200);
        header('Location: /www/users/main');
        exit();
    }


}