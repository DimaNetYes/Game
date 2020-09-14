<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 08.06.2020
 * Time: 15:43
 */

namespace Models\Users;

use Models\ActiveRecordEntity;
use Exceptions\InvalidArgumentException;

class User extends ActiveRecordEntity
{
    protected $login, $email, $email_verified_at, $password, $role, $auth_token, $updated_at;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected function getPasswordHash(): string
    {
        return $this->password;
    }

    public function getAuthToken()
    {
        return $this->auth_token;
    }

    protected static function getTableName(): string
    {
        return "users";
    }

    public static function signUp(array $userData): User
    {
        if (empty($userData['login'])) {
            throw new InvalidArgumentException('Login/Email is empty');
        }

//        if (!preg_match('/^[a-zA-Z0-9А-Яа-я]+$/', $userData['login'])) {
//            throw new InvalidArgumentException('
//Login can only consist of latin characters and numbers');
//        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('email is empty');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email incorrect');
        }

        if (!preg_match('/^[a-zA-Z0-9!@#$%^&*]+$/', $userData['password'])) {
            throw new InvalidArgumentException('Password can only consist of latin characters and numbers');
        }
        if (empty($userData['password'])) {
            throw new InvalidArgumentException('password is empty');
        }

        if (empty($userData['passwordRepeat'])) {
            throw new InvalidArgumentException('Confirm password is empty');
        }
                //Поиск Одинаковых email
        if(static::findOneByColumn('email', $userData['email']) !== null){
            throw new InvalidArgumentException('User with this email already exists');
        }

            //Создание нового пользователя
        $user = new User();
        $user->login = $userData['login'];
        $user->email = $userData['email'];
        $user->password = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->role = 'user';
        $user->auth_token = sha1(random_bytes(100)) . sha1(random_bytes(100)); //это специально случайным образом сгенерированный параметр, с помощью которого пользователь будет авторизовываться. Мы не будем передавать после того как вошли на сайт в cookie ни пароль, ни его хеш. Мы будем использовать только этот токен, который у каждого пользователя будет свой и он никак не будет связан с паролем – так безопаснее
        $user->save();
        return $user;
    }
        //Активация по email
    public function activate(): void
    {
        $this->email_verified_at = date("Y-m-d h-i-s");;
        $this->save();
    }
        //Авторизация
    public static function login(array $loginData): User
    {
        if(empty($loginData['email'])){
            throw new InvalidArgumentException('Email not sent');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Password not passed');
        }

        $user = User::findOneByColumn('email', $loginData['email']);

        if ($user === null) {
            throw new InvalidArgumentException('Incorrect email or password (Email DELETE THIS)');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Incorrect email or password (PASSWORD DELETE THIS)');
        }

//        if (!$user->isConfirmed) {
//            throw new InvalidArgumentException('User not verified'); Это пока что не надо
//        }

        $user->refreshAuthToken();
        $user->save();

        return $user;

    }

    protected function refreshAuthToken()
    {
        $this->auth_token = sha1(random_bytes(100)) . sha1(random_bytes(100));
//        var_dump($this->auth_token);
    }

    public function isAuthorized()
    {
        return ($_COOKIE['token']) ? true : false;
    }



}