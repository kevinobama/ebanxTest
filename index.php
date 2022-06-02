<?php
$request = $_SERVER['REQUEST_URI'];
//GET /balance
echo($request.PHP_EOL);
switch ($request) {
    case '/' :
        echo '/views/index.php';
        break;
    case '/reset' :
        echo "OK";
        break;
    case '/about' :
        echo '/views/about.php';
        break;
    case '/balance' :
        echo '0';
        break;
    case '/balance' :
        echo '0';
        break;
    case '/balance?account_id=1234':
        http_response_code(404);
        echo json_encode(array('0'));
        break;
    case '/event' :
        echo '{"destination": {"id":"100", "balance":10}}';
        break;
    default:
        echo '/views/404.php';
        break;
}