<?php

spl_autoload_register(function (string $className) {
    $className = substr_replace($className, '/', strpos($className, '\\'), 1);
    if(!empty(strrpos($className, '\\'))){
        $className = substr_replace($className, '/', strpos($className, '\\'), 1);
    }
    // $className = substr_replace($className, '/', strpos($className, '\\'), 1);
    // print_r($className);
    $path = realpath('../src');
    // print_r($path . '/' . $className . '.php');
    require_once $path . '/' . $className . '.php';
});

// $route =substr($_GET['route'], 0, strpos($_GET['route'], '/')) ?? '';
$route = $_GET['route'] ?? '';
$routes = require "../src/routes.php";

// require '../src/Controllers/MainController.php';
// require '../src/View/View.php';
// require '../src/Models/Users/User.php';
// require '/../ActiveRecordEntity.php';

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
