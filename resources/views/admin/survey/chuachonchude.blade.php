@extends('layouts.app')

@section('content')

<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding:0px;padding-bottom: 10px;">
  <a style='margin-top:-80px;margin-right: 25px;' class=' btchucnangdosurvey' href="{{ URL::to('survey/selectorg/0')}}">
    <img src="{{url('/')}}/public/batdaulai.png" class="" />
    <i class="fa fa-mail-reply plghidden" title="Quay Lại" style="border:1px solid #d26fae;;border-radius:5px;padding:5px;color:#d26fae;"></i>
  </a>
</div>



<?php
use Illuminate\Support\Facades\DB;
$setting=array(); 
$setting= DB::table('setting') 
            ->where('code','=','config')
            //->where('key','=','config_banner_htks')
            ->select('setting.*') 
            ->get()->toArray();
$dsetting=array();
if($setting)      
foreach ($setting as $val)
    $dsetting[$val->key]=$val->value;

if(!isset($dsetting['config_banner_htks']))$dsetting['config_banner_htks']=''; 
if(!isset($dsetting['config_ks_thankyou_htks']))$dsetting['config_ks_thankyou_htks']=''; 
if(!isset($dsetting['config_time_auto_direct']))$dsetting['config_time_auto_direct']=''; 
?>
<div class="container padding0">
<img class='bannerhome' src="{{url('/')}}/public{{$dsetting['config_banner_htks']}}"  /> 

<div style="background:#c73091;color:white;width:100%;padding:15px">
<h4><span style="font-size:48px;">Đơn vị này chưa chọn chủ đề khảo sát </span></h4>


</div>

 
 <div style="background:#c73091;color:white;width:100%;padding:0px 0px 15px 15px;" class='plghidden'>
<a style='text-decoration: none;' class='btn btn-warning' href="{{ URL('/')}}">
	Quay Lại Trang Chủ
</a>
</div>
</div>
 <script>
$(document).ready(function(){
   setTimeout(function(){ 

   	window.location ="{{url('/')}}";

	}, {{($dsetting['config_time_auto_direct']*1000)}});
});
</script>
 <script type="text/javascript">
  $('#navbarDropdown').hide();
</script>

@endsection
