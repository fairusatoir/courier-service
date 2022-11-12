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
                'status' => $raw->order->status ?? "",
                'status_description' => $raw->order->status_description ?? "",
                'matter' => $raw->order->matter  ?? "",
                'total_weight_kg' => $raw->order->total_weight_kg  ?? 0,
                'payment_amount' => $raw->order->payment_amount  ?? 0,
                'payment_amount_detail' => [
                    'delivery_fee_amount' => $raw->order->delivery_fee_amount  ?? 0,
                    'weight_fee_amount' => $raw->order->weight_fee_amount  ?? 0,
                    'insurance_fee_amount' => $raw->order->insurance_fee_amount  ?? 0,
                    'loading_fee_amount' => $raw->order->loading_fee_amount  ?? 0,
                    'money_transfer_fee_amount' => $raw->order->money_transfer_fee_amount  ?? 0,
                    'overnight_fee_amount' => $raw->order->overnight_fee_amount  ?? 0,
                    'promo_code_discount_amount' => $raw->order->promo_code_discount_amount  ?? 0,
                    'cod_fee_amount' => $raw->order->promo_code_discount_amount  ?? 0,
                    'promo_code_discount_amount' => $raw->order->promo_code_discount_amount  ?? 0
                ],
                'backpayment_details' => $raw->order->backpayment_details  ?? "",
                'is_motobox_required' => $raw->order->backpayment_details  ?? false,
                'applied_promo_code' => $raw->order->backpayment_details  ?? "",
            ];
        }else{
            $data = $raw;
        }
        return $data;
    }
}
