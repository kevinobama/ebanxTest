<?php

namespace App\Http\Controllers\Api;

use App\Helpers\HttpStatusCodes;
use App\Helpers\JwtUtils;
use Redis;

class BaseController {
    protected $httpStatusCodes;
    protected $httpStatusCodesMap;
    protected $isTokenValid;

    function __construct() {
        $this->httpStatusCodes = HttpStatusCodes::getData();
        $this->httpStatusCodesMap = array_flip($this->httpStatusCodes);

        //to do
        //Rate limiting

        //Caching
    }

    public function checkAuth() {
        if (isset($_ENV['enableAuth']) && $_ENV['enableAuth'] == "true") {
            //authentication using JWT
            $bearerToken = JwtUtils::getHearerToken();
            if ($bearerToken) $this->isTokenValid = JwtUtils::isJwtValid($bearerToken);

            if (!$this->isTokenValid) {
                $this->sendOutput(json_encode(array('error' => $this->httpStatusCodes[401])),
                    array('Content-Type: application/json', 'HTTP/1.1 401 ' . $this->httpStatusCodes[401])
                );
            }
        }
    }

    /**
     *
     * 60,5=[max attemp,second]
     *
     * X-Rate-Limit-Limit, the maximum number of requests allowed with a time period
     * X-Rate-Limit-Remaining, the number of remaining requests in the current time period
     * X-Rate-Limit-Reset, the number of seconds to wait in order to get the maximum number of allowed requests
     */
    public function rateLimit() {
        header("X-Rate-Limit-Limit: 60");
        header("X-Rate-Limit-Remaining: 55");
        header("X-Rate-Limit-Reset: " . time());

        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);

        $lastCall = $redis->get("lastCall");
        $count = $redis->get("count");

        if ($lastCall) {
            $last = strtotime($lastCall);
            $current = strtotime(date("Y-m-d h:i:s"));
            $sec = abs($last - $current);

            if ($sec <= 5 && $count > 60) {
                $this->sendOutput(json_encode(array('error' => $this->httpStatusCodes[429])),
                    array('Content-Type: application/json', 'HTTP/1.1 429 ' . $this->httpStatusCodes[429])
                );
            }
        }

        $redis->set("lastCall", date("Y-m-d h:i:s"));
        $redis->set("count", $redis->get("count") + 1);
    }

    /**
     * __call magic method.
     */
    public function __call($name, $arguments) {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);

        return $uri;
    }

    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams() {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }

    /**
     * Send API output.
     *
     * @param mixed $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders = array()) {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data;
        exit;
    }
}