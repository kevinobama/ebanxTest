<?php
require __DIR__ . "/common/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ((isset($uri[2]) && $uri[2] != 'home') || !isset($uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/HomeController.php";

$homeController = new HomeController();
$strMethodName = $uri[3] . 'Action';
$homeController->{$strMethodName}();