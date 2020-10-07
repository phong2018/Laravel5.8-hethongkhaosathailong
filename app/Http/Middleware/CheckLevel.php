<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CheckLevel
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
         $currentPath= Route::getFacadeRoot()->current()->uri();
        //check phân công xử lý hồ sơ theo bảng: task_appointed
        if(Auth::user()->user_level==1 || $currentPath=='admin/dontallowaccess')
            return $next($request);
        else{
            /*quản trị, lãnh đạo, giám sát được xem hết, nhân viên không được xem*/
            if(Auth::user()->user_level<4)
            return $next($request);
            else return redirect('/admin/dontallowaccess')->with('status', $currentPath);
            //http://localhost/2019/201906hoso1cua/admin/setting/nhatky/download/121
            
        }
    }
}
