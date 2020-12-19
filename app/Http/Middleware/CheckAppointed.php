<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CheckAppointed
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
             $appointed=1;
             $id_dor=$request->route('dossier');
             if($id_dor){
                 $appointed= DB::table('users')
                ->join('task_appointed', 'task_appointed.ID_Staff', '=', 'users.id')
                ->select('menu.*')
                ->where('users.id', '=', Auth::id())
                ->where('task_appointed.ID_Dossier','=',$id_dor)
                ->count();
            }    
            /*kết luận access*/ 
           if($appointed>0)
                return $next($request);
           else{
                return redirect('/admin/dontallowaccess')->with('status', $currentPath);
           }
        }

    }
}
