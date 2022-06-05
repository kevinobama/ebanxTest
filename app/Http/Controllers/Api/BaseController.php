<?php
namespace App\Http\Controllers\Api;

use App\Helpers\HttpStatusCodes;
use App\Helpers\JwtUtils;

class BaseController {
    protected $httpStatusCodes;
    protected $httpStatusCodesMap;
    protected $isTokenValid;

    function __construct() {
        $this->httpStatusCodes = HttpStatusCodes::getData();
        $this->httpStatusCodesMap = array_flip($this->httpStatusCodes);

        //authentication using JWT
        $bearerToken = JwtUtils::getHearerToken();
        $this->isTokenValid = JwtUtils::isJwtValid($bearerToken);

        //to do
        //Rate limiting

        //Caching
    }

    public function checkAuth() {
        if(isset($_ENV['enableAuth']) && $_ENV['enableAuth']=="true") {
            if(!$this->isTokenValid) {
                $this->sendOutput(json_encode(array('error' => $this->httpStatusCodes[401])),
                    array('Content-Type: application/json', 'HTTP/1.1 401 '.$this->httpStatusCodes[401])
                );
            }
        }
    }

    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );

        return $uri;
    }

    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }

    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
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