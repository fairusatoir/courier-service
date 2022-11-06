<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $response =  [
        'code' =>  null,
        'message' => null,
        'data' => null,
    ];

    public static function ok($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 200, $message, $data);
    }

    public static function error($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 500, $message, $data);
    }

    public static function badRequest($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 400, $message, $data);
    }

    public static function createApi($idRequest=null, $code = null, $message = null, $data = null)
    {
        $header = [
            "X-Request-Id"=>$idRequest
        ];

        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()
            ->json(self::$response, self::$response['code'], $header);
    }
}