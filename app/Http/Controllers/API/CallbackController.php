<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Helpers\LogFormatter;
use App\Helpers\ValidateEnv;
use App\Http\Controllers\Controller;
use App\Http\Services\CallbackService;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CallbackController extends Controller
{
    /**
     * List of courier orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function BorzoCallback(Request $request)
    {
        // return "test";  
        $service = "Borzo Callback";
        $idRequest = Str::uuid()->toString();
        $signature = $request->header('http_X-Dv-Signature');
        $data = $request->all();
        $vendorEnv = (object) [
            'vendor' => 'BOR1',
            'mode' => 'sit'
        ];

        try {
            LogFormatter::start(
                $idRequest,
                $service,
                array_merge($request->all(), ['signature' => $signature])
            );

            /** Validation data callback */
            if (!$signature) {
                LogFormatter::badRequest($idRequest, $service, 'Signature not found | '.$request->headers);
                return ApiFormatter::badRequest($idRequest, 'Signature not found');
            }

            /** Get vendor env data */
            $endpoint = ValidateEnv::isEnvActive($vendorEnv, $idRequest, $service);

            /** Validation data with signature */
            $dataRaw = str_replace("\\","",json_encode($data));
            $hash = hash_hmac('SHA256', $dataRaw, $endpoint->env[0]->keyCallback, false);

            // return $hash;
            if ($signature != $hash) {
                LogFormatter::badRequest($idRequest, $service, 'Signature isn\'t valid | '.$request->headers);
                return ApiFormatter::badRequest($idRequest, 'Signature isn\'t valid',);
            }

            /** Business Process */
            \DB::beginTransaction();
            
            if(!isset($data['event_type']) 
                || !in_array(
                    $data['event_type'], 
                    ['order_created','order_changed','delivery_created','delivery_changed'], 
                    true )
                ){
                LogFormatter::badRequest($idRequest, $service, 'Event isn\'t valid');
                return ApiFormatter::badRequest($idRequest, 'Event isn\'t valid',);
            }

            if(isset($data['order'])){
                $order = Orders::where('vendor_order_id',$data['order']['order_id'])->first();
                
            }elseif(isset($data['delivery'])){
                $order = Orders::where('vendor_order_id',$data['delivery']['order_id'])->first();
            }else{
                $err = 'Order not valid';
                LogFormatter::badRequest($idRequest, $service, $err);
                return ApiFormatter::badRequest($idRequest, 'NOT_VALID', $err);
            }

            if ($order == null) {
                $err = 'Order not found';
                LogFormatter::badRequest($idRequest, $service, $err);
                return ApiFormatter::notFound($idRequest, '', $err);
            }

            if(in_array(
                $data['event_type'], ['order_created','order_changed'], true )){
                $order->callback_order = $data;
                $order->status = $data['order']['status'];
            }else{
                $order->callback_delivery = $data;
                $order->status = $data['delivery']['status'];
            }

            $order->updated_at = Carbon::today();            
            $order->save();
            
            $user = User::where('id',$order->user_id)->first();
            if(isset($user) && $user->url_callback != null && $user->url_callback != "" ){
                CallbackService::sendCallback($data, $idRequest, $user->url_callback);
            }
            
            \DB::commit();

            LogFormatter::ok($idRequest, $service, $data);
            return ApiFormatter::ok($idRequest, 'Success', []);
        } catch (\Exception $ex) {
            \DB::rollback();
            LogFormatter::error($idRequest, $service, $ex);
            return ApiFormatter::error($idRequest, 'Failed', $ex);
        }
    }
}
