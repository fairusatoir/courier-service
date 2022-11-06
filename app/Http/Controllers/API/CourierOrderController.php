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

    private $rulesGlobal = [
        'mode' => 'required',
        'vendor' => 'required',
    ];

    private $messageValidationGlobal = [
        'mode.required' => 'Environment not selected',
        'vendor.required' => 'Select the Vendor to use',
    ];

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
            $rulesAdd = [
            ];
            $messageValidationAdd = [
            ];
            
            $rules = array_merge($this->rulesGlobal, $rulesAdd);
            $messageValidation = array_merge($this->messageValidationGlobal, $messageValidationAdd);

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

        try {
            LogFormatter::start($idRequest,$service,$request->all());

            /** Validation */
            $rulesAdd = [
                'data.points.*.address' => 'required',
            ];
            $messageValidationAdd = [
                'data.points.*.address.required' => 'Address cannot be empty',
            ];
            $rules = array_merge($this->rulesGlobal, $rulesAdd);
            $messageValidation = array_merge($this->messageValidationGlobal, $messageValidationAdd);

            $validator = Validator::make($request->all(), $rules, $messageValidation);

            if(!$validator->passes()){
                LogFormatter::badRequest($idRequest,$service,$validator->errors()->all());
                return ApiFormatter::badRequest($idRequest, 'Failed',$validator->errors()->all());
            }

            /** Get env vendor */
            $endpoint = ValidateEnv::isEnvActive($request, $idRequest, $service);

            /** Hit Service */
            $data = BorzoService::orderPriceCalculation($request, $idRequest, $endpoint);

            /** Response */
            LogFormatter::ok($idRequest,$service,$data);
            return ApiFormatter::ok($idRequest, 'Success', $data);
            
        } catch (Exception $ex) {
            LogFormatter::error($idRequest,$service,$ex);
            return ApiFormatter::error($idRequest,'Failed',json_encode($ex));
        }

    }
}
