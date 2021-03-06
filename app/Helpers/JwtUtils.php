<?php

namespace App\Helpers;

class JwtUtils {
    public static function generateJwt($headers, $payload, $secret = 'secret') {
        $headersEncoded = self::base64urlEncode(json_encode($headers));

        $payloadEncoded = self::base64urlEncode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$headersEncoded.$payloadEncoded", $secret, true);
        $signatureEncoded = self::base64urlEncode($signature);

        $jwt = "$headersEncoded.$payloadEncoded.$signatureEncoded";

        return $jwt;
    }

    public static function isJwtValid($jwt, $secret = 'secret') {
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        $expiration = json_decode($payload)->exp;
        $isTokenExpired = ($expiration - time()) < 0;

        $base64UrlHeader = self::base64urlEncode($header);
        $base64UrlPayload = self::base64urlEncode($payload);
        $signature = hash_hmac('SHA256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = self::base64urlEncode($signature);

        $isSignatureValid = ($base64UrlSignature === $signatureProvided);

        if ($isTokenExpired || !$isSignatureValid) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public static function base64urlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function getAuthorizationHeader() {
        $headers = null;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } else if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        return $headers;
    }

    public static function getHearerToken() {
        $headers = self::getAuthorizationHeader();

        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}