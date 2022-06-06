<?php
require __DIR__ .'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();



$router = new App\Routes\Router(new App\Routes\Request);

$router->get('/', function() {
    return "kevin gates";
});

$router->get('/balance', function($request) {
    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->balanceAction($request);
});

$router->post('/event', function($request) {

    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->eventAction($request);
});

$router->post('/reset', function($request) {
    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->resetAction($request);
});

$router->post('/token', function($request) {
    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->tokenAction($request);
});
