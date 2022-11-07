<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
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
        return "null";
        // $service = "List Order"; 
        // $idRequest = Str::uuid()->toString();

        // try {
        //     LogFormatter::start($idRequest,$service,$request->all());

        //     $signature = $request->header('HTTP_X_DV_SIGNATURE');
        //     if(!$signature){
        //         return ApiFormatter::ok($idRequest, 'Success', $data);

        //     }

        //     if (!isset($_SERVER['HTTP_X_DV_SIGNATURE'])) { 
        //         echo 'Error: Signature not found'; 
        //         exit; 
        //     } 
            
        //     $data = file_get_contents('php://input'); 
            
        //     $signature = hash_hmac('sha256', $data, '3D052694C5EDEBD52EE9E3E53783BA5D055DF7B4'); 
        //     if ($signature != $_SERVER['HTTP_X_DV_SIGNATURE']) { 
        //         echo 'Error: Signature is not valid'; 
        //         exit; 
        //     } 
            
        //     echo $data; 
        // } catch (Exception $ex) {
        //     LogFormatter::error($idRequest,$service,$ex);
        //     return ApiFormatter::error($idRequest,'Failed',json_encode($ex));
        // }
    }
}
