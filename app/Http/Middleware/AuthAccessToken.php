<?php

namespace App\Http\Middleware;

use App\Helpers\ApiFormatter;
use App\Helpers\LogFormatter;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthAccessToken
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
        $user = User::where('tokenAccess',$request->header('X-FZ-Auth-Token'))->first();
        if($user == null ){
            $err = "Unauthorized";
            LogFormatter::badRequest(null,$err);
            return ApiFormatter::unAuthorized(null, $err);
        }
        return $next($request);
    }
}
