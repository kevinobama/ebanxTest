<?php
namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Balance;
use App\Helpers\HttpStatusCodes;

class HomeController extends BaseController {
    private $httpStatusCodes;
    private $httpStatusCodesMap;

    function __construct() {
        $this->httpStatusCodes = HttpStatusCodes::getData();
        $this->httpStatusCodesMap = array_flip($this->httpStatusCodes);
    }

    //GET /balance
    public function balanceAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $balance = new Balance();
                $accountId = $_GET['account_id'];
                $response = $balance->getBalanceByAccountId($accountId);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 '.$this->httpStatusCodes[500];
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 '.$this->httpStatusCodes[422];
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $response['balance'],
                array('Content-Type: application/text', 'HTTP/1.1 '.$this->httpStatusCodesMap[$response['result']].' '.$response['result'])
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/text', $strErrorHeader)
            );
        }
    }

    //POST /event

    /**
     *
     * validate input
     *
     */
    public function eventAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        //$arrQueryStringParams = $this->getQueryStringParams();
        $jsonParams = file_get_contents('php://input');
        $jsonParams = json_decode($jsonParams,true);

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $event = new Event();
                //$data
                $response = $event->createEvent($jsonParams);
                $responseData = json_encode($response['data']);
                //http_response_code(201);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 '.$this->httpStatusCodes[500];
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 '.$this->httpStatusCodes[422];
        }

        if (!$strErrorDesc) {
            if($response['result']=="Created") {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 '.$this->httpStatusCodesMap[$response['result']].' '.$response['result'])
                );
            } else {
                $this->sendOutput(
                    $response['data'],
                    array('Content-Type: application/text', 'HTTP/1.1 '.$this->httpStatusCodesMap[$response['result']].' '.$response['result'])
                );
            }
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    //POST /reset
    public function resetAction() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $responseData = $this->httpStatusCodes[200];
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact admin.';
                $strErrorHeader = 'HTTP/1.1 500 '.$this->httpStatusCodes[500];
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 '.$this->httpStatusCodes[422];
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/text', 'HTTP/1.1 200 '.$this->httpStatusCodes[200])
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/text', $strErrorHeader)
            );
        }
    }
}