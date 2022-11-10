<?php

namespace App\Http\Entity;

use Illuminate\Http\Request;

class BorzoEntity
{

    /**
     * Limit the data sent to the client
     *
     * @param  mixed $request
     * @return void
     */
    public static function mappingOrderPriceCalculation($raw)
    {

        if($raw->is_successful == 'true'){
            $data = [
                'is_successful' => $raw->is_successful ?? "",
                'type' => $raw->order->type ?? "",
                'order_id' => $raw->order->order_id ?? "",
                'vehicle_type_id' => $raw->order->vehicle_type_id ?? 0,
                'created_datetime' => $raw->order->created_datetime ?? "",
                'finish_datetime' => $raw->order->finish_datetime ?? "",
                'matter ' => $raw->order->matter  ?? "",
                'total_weight_kg ' => $raw->order->total_weight_kg  ?? 0,
            ];
        }else{
            $data = $raw;
        }
        return $data;
    }
}
