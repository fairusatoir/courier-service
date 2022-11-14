<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Helpers\LogFormatter;
use App\Helpers\ValidateEnv;
use App\Http\Controllers\Controller;
use App\Http\Services\BorzoService;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CourierOrderController extends Controller
{
    /**
     * List of courier orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $service = "List Order";
        $idRequest = Str::uuid()->toString();

        try {
            LogFormatter::start($idRequest,$service,$request->all());

            /** Validation */
            $rules = [
            ];
            $messageValidation = [
            ];

            $validator = Validator::make($request->all(), $rules, $messageValidation);

            if(!$validator->passes()){
                LogFormatter::badRequest($idRequest,$service,$validator->errors()->all());
                return ApiFormatter::badRequest($idRequest, 'Failed',$validator->errors()->all());
            }

            /** Get env vendor */
            $endpoint = ValidateEnv::isEnvActive($request, $idRequest, $service);

            /** Hit Service */
            $data = BorzoService::getListOrder($request, $idRequest, $endpoint);

            /** Response */
            LogFormatter::ok($idRequest,$service,$data);
            return ApiFormatter::ok($idRequest, 'Success', $data);

        } catch (Exception $ex) {
            LogFormatter::error($idRequest,$service,$ex);
            return ApiFormatter::error($idRequest,'Failed',json_encode($ex));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Calculate order prices and validate parameters before actually placing the order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculatePrice(Request $request)
    {
        $service = "Order Price Calculation";
        $idRequest = Str::uuid()->toString();

        LogFormatter::start($idRequest,$service,$request->all());
        
        try {

            /** Validation */
            $rules = [
                /** Minimal Request */
                'data.type'                 => 'required|in:standard,same_day',
                'data.matter'               => 'max:4999',
                'data.vehicle_type_id'      => 'required|numeric|in:1,2,3,7,8',
                'data.total_weight_kg'      => 'required_if:data.type,same_day',
                'data.points.*.address'     => 'required',

                /** Additional */
                'data.insurance_amount'     => 'numeric|min:0',
                'data.is_client_notification_enabled' => 'boolean',
                'data.is_contact_person_notification_enabled' => 'boolean',
                'data.is_route_optimizer_enabled' => 'boolean',
                'data.loaders_count'        => 'numeric|min:0|max:11',
                'data.backpayment_details'  => 'max:300',
                'data.is_motobox_required'  => 'boolean',
                'data.payment_method'       => 'string|in:cash,non_cash,bank_card',
                'data.bank_card_id'         => 'numeric|nullable|required_if:data.payment_method,bank_card',
                'data.promo_code'           => '',
            ];
            $messageValidation = [
                'data.vehicle_type_id.required' => 'VEHICLE cannot be empty',
                'data.vehicle_type_id.in'       => 'Vehicle not available ',
                'data.type.required'            => 'TYPE ORDER cannot be empty',
                'data.type.in'                  => 'Select the type order used: STANDARD, SAME DAY',
                'data.points.*.address.required' => 'ADDRESS cannot be empty',
            ];

            $validator = Validator::make($request->all(), $rules, $messageValidation);

            if(!$validator->passes()){
                LogFormatter::badRequest($idRequest,$service,$validator->errors()->all());
                return ApiFormatter::badRequest($idRequest, 'Failed',$validator->errors()->all());
            }

            if(count($request->data['points']) > 99 ){
                LogFormatter::badRequest($idRequest,$service,'Order standard type maximum 99');
                return ApiFormatter::badRequest($idRequest, 'Failed','Order standard type maximum 99');
            }

            /** Filter Parameters */
            $dataReq = $request->all();

            if(in_array($request->data['type'] ?? "",['same_day'])){
                unset($dataReq['data']['total_weight_kg']);
                $request->replace($dataReq);
            }

            if(in_array($request->data['payment_method'] ?? "",['bank_card'])){
                unset($dataReq['data']['bank_card_id']);
                $request->replace($dataReq);
            }

            $request->replace($dataReq);

            /** Get env vendor */
            $endpoint = ValidateEnv::isEnvActive($request, $idRequest, $service);

            /** Hit Service */
            $data = BorzoService::orderPriceCalculation($request, $idRequest, $endpoint);

            /** Response */
            LogFormatter::ok($idRequest,$service,$data);
            return ApiFormatter::ok($idRequest, 'Success', $data);

        } catch (\Throwable $ex) {
            LogFormatter::error($idRequest,$service,$ex);
            return ApiFormatter::error($idRequest,'Failed',$ex);
        }

    }
}
