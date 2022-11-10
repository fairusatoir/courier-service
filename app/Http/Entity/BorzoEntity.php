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

        if($raw->is_successful = 'true'){
            $data = [
                'is_successful' => $raw->is_successful ?? "",
                'type' => $raw->orders->type ?? "",
                'order_id' => $raw->orders->order_id ?? "",
                'vehicle_type_id' => $raw->orders->vehicle_type_id ?? 0,
                'created_datetime' => $raw->orders->created_datetime ?? "",
                'finish_datetime' => $raw->orders->finish_datetime ?? "",
                'matter ' => $raw->orders->matter  ?? "",
                'total_weight_kg ' => $raw->orders->total_weight_kg  ?? 0,
            ];
        }else{
            $data = $raw;
        }
        return $data;
    }
}
