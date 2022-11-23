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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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

    /**
     * Get Delivery Interval to Orders
     *
     * @param  mixed $request
     * @return \Illuminate\Http\Response
     */
    public static function deliveryInterval(Request $request, $idRequest, $endpoint)
    {
        $dataResp = MakeRequest::_get(
            self::initHeader($endpoint->env[0]->key),
            $endpoint->env[0]->endpoint . "/delivery-intervals",
            $request,
            $idRequest
        );

        self::checkRequiredParams("Calculate",$idRequest, $dataResp);
        return $dataResp;
    }

    /**
     * Prepare request body
     * Rule following https://borzodelivery.com/id/business-api/doc#create-order
     */
    public static function prepareRequest(Request $request)
    {
        /** Filter Parameters */
        $dataReq = $request->all();

        /** In same_day orders it is prohibited to set this parameter vehicle_type_id. It will be detected automatically. */
        if (in_array($request->data['type'] ?? "", ['same_day'])) {
            unset($dataReq['data']['vehicle_type_id']);
        }

        /** In same_day orders total_weight_kg parameter is required. Must be greater than 0. */
        if (in_array($request->data['type'] ?? "", ['same_day'])) {
            unset($dataReq['data']['total_weight_kg']);
        }

        if (in_array($request->data['payment_method'] ?? "", ['bank_card'])) {
            unset($dataReq['data']['bank_card_id']);
            $request->replace($dataReq);
        }

        return $dataReq;
    }
}
