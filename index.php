<?php
require __DIR__ . "/common/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
//print_r($uri);
//$uri[2] is controller,$uri[3] is action
//if (!isset($uri[2]) || !isset($uri[3])) {
//    header("HTTP/1.1 404 Not Found");
//    exit();
//}

if (!isset($uri[1])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

//if($uri[2]=="event")

//print_r($uri);
require PROJECT_ROOT_PATH . "/Controller/Api/HomeController.php";
require PROJECT_ROOT_PATH . "/Model/Balance.php";
require PROJECT_ROOT_PATH . "/Model/Event.php";

$homeController = new HomeController();
$strMethodName = $uri[1] . 'Action';
//exit($strMethodName);
$homeController->{$strMethodName}();