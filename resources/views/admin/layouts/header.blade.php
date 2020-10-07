<?php
use Illuminate\Support\Facades\DB;
 
$setting=array(); 
$setting= DB::table('setting') 
            ->where('code','=','config')
            ->select('setting.*') 
            ->get()->toArray();
$dsetting=array();
if($setting)      
foreach ($setting as $val)
    $dsetting[$val->key]=$val->value;   

if(!isset($dsetting['config_logoadmin_qlp']))$dsetting['config_logoadmin_qlp']='';


$dsetting['config_tenphuong']='';

$tempus= DB::table('users') 
            ->where('id','=',Auth::id())
            ->get()->first();

if($tempus->user_level>1){
    $orgt=DB::table('ks_organization') 
            ->where('org_id','=',$tempus->user_IdOrg)
            ->get()->first();

 

    if($orgt->org_level==2){
       $org=DB::table('ks_organization') 
            ->where('org_id','=',$orgt->org_idParent)
            ->get()->first(); 
    }
    else{
     $org=DB::table('ks_organization') 
            ->where('org_id','=',$tempus->user_IdOrg)
            ->get()->first();
    }

    $dsetting['config_tenphuong']= ' - '.$org->org_name;
} 


?>
<header id="header" class="navbar navbar-static-top">
   <div class="navbar-header">
        <a href="#" id="button-menu"  class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span><i class="fa fa-dedent fa-lg"></i></span>
    </a>
        <a href="#" class="navbar-brand   ">
          <h3 style="color:white"><strong>{{$dsetting['config_ks_meta_title']}}{{$dsetting['config_tenphuong']}}</strong></h3>
          <img class='logoadmin plghidden' src="{{url('/')}}/public{{$dsetting['config_logoadmin_qlp']}}"  ></a>
    </div>
  
    <ul class="nav pull-right">
    <li class="dropdown plghidden"><a class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger pull-left">1</span> <i class="fa fa-bell fa-lg"></i></a>
      <ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
        <li class="dropdown-header">Đơn đặt hàng</li>
        <li><a href="http://localhost/2019/201903ocframework/admin/index.php?route=sale/order&amp;token=mAD6nrD98hfNFy9go3G5FbmoxrLAVRLj&amp;filter_order_status=5,1,2,12,3" style="display: block; overflow: auto;"><span class="label label-warning pull-right">0</span>Đang xử lý</a></li>
         
      </ul>
    </li>
  <li>

    <li style="margin-top: -22px;">

      
    <a  href="{{ url()->previous() }}" id="nutquaylai"  target="_self">
          <i class="fa fa-mail-reply"></i>&nbsp<span class="hidden-xs hidden-sm hidden-md">Quay Lại</span>
    </a>


    <a  href="{{url('/')}}"  target="_blank">
          <span class="glyphicon glyphicon-home"></span>&nbsp<span class="hidden-xs hidden-sm hidden-md">Trang Chủ</span>
    </a>

    <a class="dropdown-item" href="{{ route('logout') }}"
       onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
        <span class="hidden-xs hidden-sm hidden-md">Thoát</span> <i class="fa fa-sign-out fa-lg"></i>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
                  
  
 
     
  </ul>
  </header>