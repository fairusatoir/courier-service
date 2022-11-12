<?php

namespace App\Helpers;

class ApiFormatter
{

    public static function ok($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 200, $message, $data);
    }

    public static function error($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 500, $message, $data->getMessage());
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

        $body = [
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ];

        return response()
            ->json($body, $code, $header);
    }
}