<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Helpers\LogFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    /**
     * List of courier orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function BorzoCallback(Request $request)
    {        
        $service = "Borzo Callback"; 
        $idRequest = Str::uuid()->toString();
        $signature = $request->HTTP_X_DV_SIGNATURE;
        $data = $request->all();
        $vendorEnv = [
                'vendor' => 'BOR1',
                'mode' => 'sit'
        ];

        try {
            LogFormatter::start($idRequest,$service,
                array_merge($request->all(), ['signature' => $signature]));
            
            /** Validation data callback */
            if(!$signature){
                LogFormatter::badRequest($idRequest,$service,'Signature not found');
                return ApiFormatter::badRequest($idRequest, 'Signature not found');
            }
            
            /** Get vendor env data */
            $endpoint = ValidateEnv::isEnvActive($vendorEnv, $idRequest, $service);
            
            /** Validation data with signature */
            $signature = hash_hmac('sha256', json_encode($data), $endpoint->env[0]->keyCallback);
            if ($signature != $_SERVER['HTTP_X_DV_SIGNATURE']) { 
                LogFormatter::badRequest($idRequest,$service,'Signature is not valid');
                return ApiFormatter::badRequest($idRequest, 'Signature is not valid',);
            } 

            /** Business Process */
                        
            
            LogFormatter::ok($idRequest,$service,$data);
            return ApiFormatter::ok($idRequest, 'Success', []);
        } catch (Exception $ex) {
            LogFormatter::error($idRequest,$service,$ex);
            return ApiFormatter::error($idRequest,'Failed',json_encode($ex));
        }
    }
}
