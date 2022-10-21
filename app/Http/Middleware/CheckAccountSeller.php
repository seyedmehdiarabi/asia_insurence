<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccountSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->account_status=='active')
        {
            return $next($request);
        }
        else{
            return response()->json(['error_access'=>'ok','account_status'=>$request->user()->account_status]);
        }
        
    }
}
