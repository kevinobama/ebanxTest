<?php
require __DIR__ .'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$appName = $_ENV['appName'];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
//print_r($uri);
//$uri[2] is controller,$uri[3] is action
//if (!isset($uri[2]) || !isset($uri[3])) {
//    header("HTTP/1.1 404 Not Found");
//    exit();
//}

$router = new App\Routes\Router(new App\Routes\Request);

$router->get('/', function() {
    return "kevin gates";
});

$router->get('/balance', function($request) {
    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->balanceAction();
});

$router->post('/event', function($request) {
    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->eventAction();
});

$router->post('/reset', function($request) {
    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->resetAction();
});

$router->post('/token', function($request) {
    $homeController = new App\Http\Controllers\Api\HomeController();
    $homeController->tokenAction();
});

//exit;
//if (!isset($uri[1])) {
//    header("HTTP/1.1 404 Not Found");
//    exit();
//}

//$homeController = new App\Http\Controllers\Api\HomeController();
//$strMethodName = $uri[1] . 'Action';
////exit($strMethodName);
//$homeController->{$strMethodName}();