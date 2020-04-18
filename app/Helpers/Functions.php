<?php

namespace App\Helpers;
use JWTAuth;

class Functions
{
    public static function getUserId()
    {

        $token = JWTAuth::getToken();
        $apy = JWTAuth::getPayload($token)->toArray();
        return $apy['sub'];
    }
}