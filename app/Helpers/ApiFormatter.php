<?php

namespace App\Helpers;

use Str;

use function PHPUnit\Framework\isNull;

class ApiFormatter
{

    public static function ok($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 200, $message, $data);
    }

    public static function notFound($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 404, "Not_Found", $data);
    }

    public static function error($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, $data->getCode() ? $data->getCode() : 500, $message, $data->getMessage());
    }

    public static function badRequest($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 400, $message, $data);
    }

    public static function unAuthorized($idRequest=null, $message = null, $data = null)
    {
        return self::createApi($idRequest, 401, $message, $data);
    }

    public static function createApi($idRequest=null, $code = null, $message = null, $data = null)
    {
        $header = [
            "X-Request-Id"=>$idRequest ?? Str::uuid()->toString()
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
