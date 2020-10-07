<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;


class CheckAccessMenu
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
        $currentPath= Route::getFacadeRoot()->current()->uri().';';

        $vt= strpos($currentPath,"/");

        //$currentPath=substr($currentPath,$vt+1,strlen($currentPath)-$vt);



        if(Auth::user()->user_level==1 || $currentPath=='admin/dontallowaccess')
            return $next($request);
        else{
           
           //check quyền truy cập menu theo role_menu
           $menu= DB::table('ks_menu')
            ->join('ks_menu_role', 'ks_menu.ID_Menu', '=', 'ks_menu_role.ID_Menu')
            ->join('role', 'ks_menu_role.ID_Role', '=', 'role.ID_Role')
            ->join('users', 'role.ID_Role', '=', 'users.ID_Role')
            ->select('ks_menu.*')
            ->where('users.id', '=', Auth::id())
            ->where('ks_menu.menu_route','like','%'.$currentPath.'%')
            ->count();
            
           /*kết luận access*/ 
           if($menu>0)
                return $next($request);
           else{
                return redirect('admin/dontallowaccess')->with('status', $currentPath);
           }
        }
         
        
        

    }
}
/*
- thêm super_user vào user để quản ko quan tâm cái middleware này-> có quyền truy cập tất cả.
- mặc định ko có quyền truy cập tất cả, cái middleware này chỉ dùng cho suppervisor và user (người dùng thôi)/ hiện ra cái có khả năng truy cập được.
//=============== 
echo URL::current();
echo '---------';
echo Route::getFacadeRoot()->current()->uri();
echo '---------';
*/