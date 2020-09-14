<?php
return [
    '~^hello/(.*)$~' => [\Controllers\MainController::class, 'sayHello'],
    '~^users/login$~' => [\Controllers\UsersController::class, 'login'],
    '~^users/register$~' => [\Controllers\UsersController::class, 'signUp'],
    '~^users/out~' => [\Controllers\UsersController::class, 'out'],
    '~^users/main$~' => [\Controllers\UsersController::class, 'main'],
    '~^users/(\d+)/activate/(.+)$~' => [\Controllers\UsersController::class, 'activate'],
    '~^games/fastDigit$~' => [\Controllers\FastDigitController::class, 'main'],
    '~^delete$~' => [\Controllers\FastDigitController::class, 'delete'],
    '~^$~' => [\Controllers\MainController::class, 'main'],
];