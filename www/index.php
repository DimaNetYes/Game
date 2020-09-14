<?php

//require("../src/Exceptions/ErrorHandler.php");
//(new Exceptions\ErrorHandler())->register();

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../src/' . $className . '.php';
});

$route = $_GET['route'] ?? '';
$routes = require "../src/routes.php";

$isRouteFound = false;
foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}
if (!$isRouteFound) {
    echo 'Страница не найдена!';
    return;
}

unset($matches[0]); //matches передает аргументы в controller

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();
$controller->$actionName(...$matches);

