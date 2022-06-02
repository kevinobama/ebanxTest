<?php
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        echo '/views/index.php';
        break;
    case '' :
        echo '/views/index.php';
        break;
    case '/about' :
        echo '/views/about.php';
        break;
    default:
        echo '/views/404.php';
        break;
}