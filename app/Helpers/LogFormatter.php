<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LogFormatter
{

    public static function start($idRequest = null, $service = null, $data = null)
    {
        self::logFormat($idRequest, "START", $service, json_encode($data ?? []));

    }

    public static function ok($idRequest = null, $service = null, $data = null)
    {
        self::logFormat($idRequest, "SUCCESS", $service, json_encode($data ?? []));

    }

    public static function badRequest($idRequest = null, $service = null, $data = null)
    {
        self::logFormat($idRequest, "BAD_REQUEST", $service, $data);

    }

    public static function unAuthorized($idRequest = null, $service = null, $data = null)
    {
        self::logFormat($idRequest, "UNAUTHORIZED", $service, $data);

    }

    public static function error($idRequest = null, $service = null, $ex=null)
    {
        Log::error([
            'idRequest'=> $idRequest,
            'message'=> "[ERROR][".$service."] ".$ex->getMessage(),
            'file'=> $ex->getFile().' | line'.$ex->getLine(),
        ]);
    }

    public static function logFormat($idRequest = null, $status = "", $service = null, $data = null)
    {
        Log::info([
            'idRequest'=> $idRequest,
            'message'=> "[".$status."][".$service."]",
            'data'=> $data
        ]);
    }
}