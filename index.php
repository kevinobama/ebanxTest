<?php
$request = $_SERVER['REQUEST_URI'];
//GET /balance

switch ($request) {
    case '/' :
        echo '/views/index.php';
        break;
    case 'reset' :
        echo "OK";
        break;
    case '/about' :
        echo '/views/about.php';
        break;
    case '/balance' :
        echo '0';
        break;
    case '/event' :
        echo '{"destination": {"id":"100", "balance":10}}';
        break;
    default:
        echo '/views/404.php';
        break;
}