<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

class CallbackService
{
    /**
     * Init header for request
     *
     * @return void
     */
    private static function initHeader($key)
    {
        return [
            'X-DV-Auth-Token:' . $key,
        ];
    }

    /**
     * Order courier
     *
     * @param  mixed $request
     * @return Order
     */
    public static function sendCallback($data, $idRequest, $endpoint)
    {
        $dataResp = MakeRequest::_post(
            self::initHeader($endpoint->env[0]->key),
            $endpoint->env[0]->endpoint,
            $data,
            $idRequest
        );

        return $dataResp;
    }
}
