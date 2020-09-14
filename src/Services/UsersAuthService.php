<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 29.07.2020
 * Time: 4:54
 */

namespace Services;

use Models\Users\User;

/*
 *Создание токена, вместо передачи пароля или куки
 *
 */

class UsersAuthService
{

    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, time()+3600, '/', '', false, true);
    }

    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int) $userId);

        if ($user === null) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        }

        return $user;
    }

}