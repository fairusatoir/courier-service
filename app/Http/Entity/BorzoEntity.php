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
    public static function LimitOrderPriceCalculation($raw)
    {
        $data = [
            'is_successful' => $raw->is_successful,
        ];
        return $data;
    }
}
