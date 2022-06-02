<?php
$request = $_SERVER['REQUEST_URI'];
//GET /balance
//echo($request.PHP_EOL);
switch ($request) {
    case '/' :
        echo 'index.php';
        break;
    case '/reset' :
        http_response_code(200);
        echo "OK";
        break;
    case '/balance' :
        echo '0';
        break;
    case '/balance' :
        echo '0';
        break;
    case '/balance?account_id=1234':
        http_response_code(404);
        echo '0';
        break;
     ///balance?account_id=100
    case '/balance?account_id=100':
        http_response_code(200);
        echo '20';
        break;
    case '/event' :
        echo '{"destination": {"id":"100", "balance":10}}';
        http_response_code(200);
        break;
    default:
        http_response_code(404);
        echo '404';
        break;
}