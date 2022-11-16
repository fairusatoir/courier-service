<?php

namespace App\Helpers;

use App\Models\Vendor;
use Illuminate\Support\Facades\Log;

class ValidateEnv
{

    public static function isEnvActive($request, $idRequest = null, $service = null,)
    {
        /** Get env vendor */
        $endpoint = Vendor::active()->with('env', function ($query) use ($request) {
            $query->where("mode", $request->mode)->first();
        })
            ->where("slug", $request->vendor)
            ->first();

        return $endpoint;
    }
}
