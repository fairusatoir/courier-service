<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Vendor::with('env')
            ->with('order_type')
            ->with('vehicle_type')
            ->get();

            /** Response */
            return ApiFormatter::ok(null, 'Success', $data);

        } catch (\Exception $ex) {
            return ApiFormatter::error(null,'Failed',$ex);
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
        try{
            $data = Vendor::with('env')
            ->with('order_type')
            ->with('vehicle_type')
            ->with('payment_type')
            ->find($id);

            
            /** Response */
            return ApiFormatter::ok(null, 'Success', $data);

        } catch (\Throwable $ex) {
            return ApiFormatter::error(null,'Failed',$ex);
        }
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
}
