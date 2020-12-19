<?php
use App\Position;

use Illuminate\Support\Facades\DB;

/*tính số hồ sơ quá hạn*/
$dossier_quahan= DB::table('dossier')
            ->join('task_appointed', 'task_appointed.ID_Dossier', '=', 'dossier.ID_Dossier')
            ->join('users', 'users.id', '=', 'task_appointed.ID_Staff')
            ->join('list_step', 'list_step.ID_Step', '=', 'dossier.id_stepcurrent')
            ->select('dossier.*')
            ->where('users.id', '=', Auth::id()) 
            ->where('list_step.out_ofdate', '=', 1)
            ->where('dossier.is_actived', '=',1)
            ->where('dossier.time_return', '<', date("Y-m-d H:i:s"))
            ->count(); 

 


//echo 'Role: '.Auth::user()->ID_Role.'<br>';
//echo 'Positon: '.Auth::user()->ID_Position.'<br>';
$pos=Position::find(Auth::user()->ID_Position);
  
/*tính các menu hiển thị ra được*/
$menu= DB::table('ks_menu_role')
            ->join('ks_menu', 'ks_menu_role.ID_Menu', '=', 'ks_menu.ID_Menu')
            ->select('ks_menu.*')
            ->where('ks_menu_role.ID_Role', '=', Auth::user()->ID_Role)
            ->where('ks_menu.menu_show', '=', 1)
            ->where('ks_menu.menu_active', '=', 1)
            ->orderBy('ks_menu.menu_level', 'asc')
            ->orderBy('ks_menu.menu_order', 'asc')
            ->get()->toArray();

/*Hàm tạo menu*/
$strmenu='';
$checkmenu=array();
//print_r($menu);
for($i=0;$i<count($menu);$i++)
//============================
if(!isset($checkmenu[$menu[$i]->ID_Menu]))
{
  /*bỏ dấu ; ở cuối đi. dấu chấm phẩy để xét quyền truy cập cho chính xác*/
  $mn=explode(';',$menu[$i]->menu_route);if(count($mn)==0) $mn[0]='';
  $menu[$i]->menu_route=$mn[0];

  $checkmenu[$menu[$i]->ID_Menu]=1;
  if($menu[$i]->menu_route!=''){
      $strmenu.='<li id="id'.$i.'"><a class=" " href="'.URL($menu[$i]->menu_route).'"><i class="fa fa-tags fa-fw"></i> <span>'.$menu[$i]->menu_name.'</span></a></li>';
  }
  else{
    $strmenu.='<li id="id'.$i.'"><a class="parent"><i class="fa fa-tags fa-fw"></i> <span>'.$menu[$i]->menu_name.'</span></a>';
    $strmenu.='<ul>';
        for($j=0;$j<count($menu);$j++)
        //============================
        if(!isset($checkmenu[$menu[$j]->ID_Menu])&&($menu[$i]->ID_Menu==$menu[$j]->menu_parent) && $menu[$j]->menu_route!='')/*Chưa chọn và là cha*/
        {
          /*bỏ dấu ; ở cuối đi. dấu chấm phẩy để xét quyền truy cập cho chính xác*/
          $mn=explode(';',$menu[$j]->menu_route);if(count($mn)==0) $mn[0]='';
          $menu[$j]->menu_route=$mn[0];

          /*count số lượng hồ sơ trong quy trình link này nếu có
          vd route dạng: admin/dossier/dossierstep/3
          */
    
          $arrroutelink=(explode("/",$menu[$j]->menu_route));
          //print_r($arrroutelink);
          $strcount='';
          /*tính số hồ sơ tại link này*/
          if(  $arrroutelink[2]=='dossierstep'){
               $countdor=DB::table('dossier')
                ->join('task_appointed', 'task_appointed.ID_Dossier', '=', 'dossier.ID_Dossier')
                ->join('users', 'users.id', '=', 'task_appointed.ID_Staff')
                ->where('dossier.id_stepcurrent', '=',$arrroutelink[3])
                ->where('dossier.is_actived', '=',1)
                ->where('users.id', '=', Auth::id()) 
                ->count(); 

              $strcount=' <span class="countdor">('.$countdor.')</span>';
          }
          /*số lượng hồ sơ quá hạn*/
          if( $menu[$j]->menu_route=='admin/dossier/c/quahan'){
              $strcount=' <span class="countdor">('.$dossier_quahan.')</span>';
          }

          $checkmenu[$menu[$j]->ID_Menu]=1;
          if($menu[$j]->menu_route==''){
            $strmenu.='<li><a class="parent">'.$menu[$j]->menu_name.'</a>';
            for($e=0;$e<count($menu);$e++)
            //============================
            if(!isset($checkmenu[$menu[$e]->ID_Menu])&&($menu[$j]->ID_Menu==$menu[$e]->menu_parent))/*Chưa chọn và là cha*/
            {
               /*bỏ dấu ; ở cuối đi. dấu chấm phẩy để xét quyền truy cập cho chính xác*/
               $mn=explode(';',$menu[$e]->menu_route);if(count($mn)==0) $mn[0]='';
               $menu[$e]->menu_route=$mn[0];

               $checkmenu[$menu[$e]->ID_Menu]=1;
               $strmenu.='<li><a href="'.URL($menu[$e]->menu_route).'">'.menu[$e]->menu_name.'</a></li>';
            }
            $strmenu.='</li>';    
          }
          else{ 
            $strmenu.='<li><a href="'.URL($menu[$j]->menu_route).'"  class="">'.$menu[$j]->menu_name. $strcount.'</a>';
            $strmenu.='</li>';    
          }
        }  
    $strmenu.='</ul>';
    $strmenu.='</li>';
  }
}
?>




<nav id="column-left" class="active">
  <!-- Sidebar user panel -->
    
  <div id="profile">
  <div class="user-panel">
      <div class="pull-left image">
        <a href='{{url("admin/user/c/manageinfo")}}'>
        <img src="{{url('/')}}/public/{{ Auth::user()->avatar }}" class="img-circle avatathumb" alt="User Image">
        </a>
      </div>
      <div class="pull-left info">
        <a style='color:white;' href='{{url("admin/user/c/manageinfo")}}'>
        <span class='nameus' style=" ">{{ Auth::user()->fullname }}</span>
        </a>
        <br>{{$pos->pos_name}}
        
      </div>
    </div>
  </div>
<ul id="menu">

<!-- Là superuser thì toàn quyền thấy menu -->
@if(Auth::user()->user_level==1)
       <li id="quanlyhoso" class='plghidden'><a class="parent"><i class="fa fa-tags fa-fw"></i> <span>Quản Lý Hồ Sơ</span></a>
          <ul class="collapse"   style="height: 0px;">
            <li><a href="#">Danh Sách Hồ Sơ</a></li>
            <li><a href="#"> Thêm Hồ Sơ Mới</a></li>
          </ul>
        </li>

       <li id="thuoctinhhoso"><a class="parent"><i class="fa fa-puzzle-piece fa-fw"></i> <span>Quản lý Khảo sát</span></a>
          <ul class="collapse" >
            <li><a href="<?php echo e(asset('/admin/topic')); ?>">Quản Lý Chủ Đề</a></li>
            <li><a href="<?php echo e(asset('/admin/organization')); ?>"> Quản lý đơn vị</a></li>
            <li><a href="<?php echo e(asset('/admin/survey/surveyresult')); ?>"> Báo cáo khảo sát</a></li>
          </ul>
        </li>
        <li id="taikhoan" ><a class="parent"><i class="fa fa-user fa-fw"></i> <span>Tài Khoản & Tổ chức</span></a>
          <ul class="collapse" >
            <li><a href="<?php echo e(asset('/admin/user')); ?>">Quản lý Tài Khoản</a></li>
            <li><a href="<?php echo e(asset('/admin/position')); ?>">Quản Lý Chức Vụ</a></li>
            <li><a href="<?php echo e(asset('/admin/role')); ?>">Quản Lý Vai Trò</a></li>
            <li><a href="<?php echo e(asset('/admin/menu')); ?>"> Menu & Quyền truy cập</a></li>
            

          </ul>
        </li>

        <li id="caidathethong"  ><a class="parent"><i class="fa fa-cog fa-fw"></i> <span>Cài Đặt Hệ Thống</span></a>
          <ul class="collapse" >
            <li><a href="<?php echo e(asset('/admin/setting/edit')); ?>">Thiết Lập Chung</a></li>
              <li><a href="<?php echo e(asset('/admin/temp')); ?>">Quản Lý Mẫu</a></li>
            <li><a href="<?php echo e(asset('/admin/backup')); ?>"> Sao Lưu/ Phục Hồi</a></li>
          </ul>
        </li>
        {!! $strmenu !!}
@else
{!! $strmenu !!}
@endif
</ul>
</nav>