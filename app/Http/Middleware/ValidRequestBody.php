<?php

namespace App\Http\Middleware;

use App\Helpers\ApiFormatter;
use App\Helpers\LogFormatter;
use Closure;
use Illuminate\Http\Request;
use Validator;

class ValidRequestBody
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $rules = [
            'mode' => 'required',
            'vendor' => 'required',
        ];
    
        $messageValidation = [
            'mode.required' => 'Environment not selected',
            'vendor.required' => 'Select the Vendor to use',
        ];

        $validator = Validator::make($request->all(), $rules, $messageValidation);

        if(!$validator->passes()){
            LogFormatter::badRequest(null,"System Validation",$validator->errors()->all());
            return ApiFormatter::badRequest(null, 'System Validation',$validator->errors()->all());
        }

        return $next($request);
    }
}
