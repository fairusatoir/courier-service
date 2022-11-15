<?php

namespace App\Http\Services;

use App\Helpers\ApiFormatter;
use App\Helpers\LogFormatter;
use App\Http\Entity\BorzoEntity;
use Illuminate\Http\Request;

class BorzoService
{

    private static $url;
    private static $token;

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

    private static function checkRequiredParams($err,$idRequest, $dataResp)
    {
        if (!isset($dataResp->is_successful)) {
            LogFormatter::error($idRequest, "Borzo Process", $err);
            return ApiFormatter::error($idRequest, 'Failed', $err);
        }
    }

    /**
     * Order courier
     *
     * @param  mixed $request
     * @return Order
     */
    public static function orders(Request $request, $idRequest, $endpoint)
    {
        $dataResp = MakeRequest::_post(
            self::initHeader($endpoint->env[0]->key),
            $endpoint->env[0]->endpoint . "/create-order",
            $request,
            $idRequest
        );

        self::checkRequiredParams('Response Order not valid',$idRequest, $dataResp);
        return $dataResp;
    }

    /**
     * Calculate order prices and validate parameters before actually placing the order
     *
     * @param  mixed $request
     * @return void
     */
    public static function getListOrder(Request $request, $idRequest, $endpoint)
    {
        return MakeRequest::_get(
            self::initHeader($endpoint->env[0]->key),
            $endpoint->env[0]->endpoint . "/orders?status=" . $request->status,
            $request,
            $idRequest
        );
    }

    /**
     * Calculate order prices and validate parameters before actually placing the order
     *
     * @param  mixed $request
     * @return void
     */
    public static function orderPriceCalculation(Request $request, $idRequest, $endpoint)
    {
        $dataResp = MakeRequest::_post(
            self::initHeader($endpoint->env[0]->key),
            $endpoint->env[0]->endpoint . "/calculate-order",
            $request,
            $idRequest
        );

        self::checkRequiredParams("Calculate",$idRequest, $dataResp);
        return $dataResp;
    }
}
