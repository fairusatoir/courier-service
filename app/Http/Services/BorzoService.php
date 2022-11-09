<?php

namespace App\Http\Services;

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
            'X-DV-Auth-Token:'. $key,
        ];
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
            $endpoint->env[0]->endpoint."/orders?status=".$request->status, 
            $request, $idRequest );
    }

    /**
     * Calculate order prices and validate parameters before actually placing the order
     *
     * @param  mixed $request
     * @return void
     */
    public static function orderPriceCalculation(Request $request, $idRequest, $endpoint)
    { 
        return BorzoEntity::LimitOrderPriceCalculation( 
            MakeRequest::_post(
            self::initHeader($endpoint->env[0]->key), 
            $endpoint->env[0]->endpoint."/calculate-order", 
            $request, $idRequest )
        );
    }
}