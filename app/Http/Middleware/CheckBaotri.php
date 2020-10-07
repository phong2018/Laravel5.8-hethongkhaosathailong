<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Setting;

class CheckBaotri
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

        if( Auth::user()==null || Auth::user()->user_level==1 )
            return $next($request);
        else{
            if(Setting::getconfig('config_maintenance')==1)
            return redirect('/baotri');
            else return $next($request);
        }
    }
}
