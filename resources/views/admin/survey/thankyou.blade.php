@extends('layouts.app')

@section('content')

<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding:0px;padding-bottom: 10px;">
  <a style='margin-top:-80px;margin-right: 25px;' class=' btchucnangdosurvey' href="{{url('/')}}">
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

<?php echo $dsetting['config_ks_thankyou_htks'];?>

<a class='btn btn-warning plghidden' id='kqks' href="">Xem kết quả kháo sát</a>
<br><br>
<style type="text/css">
  #kqks{
    padding:10px;

  }
</style>
 
 <div style="background:#c73091;color:white;width:100%;padding:0px 0px 15px 15px;" class='plghidden'>
<a style='text-decoration: none;' class='btn btn-warning' href="{{ URL('/')}}">
	Quay Lại Trang Chủ
</a>
</div>
</div>

 <script type="text/javascript">
  $('#navbarDropdown').hide();
</script>



<script>
   
 
 

function kiemtrathietbi(){
 

    var divideid;
    // Check browser support
    if (typeof(Storage) !== "undefined") {
          
          // Retrieve
          if(localStorage.getItem("divideid")){
                //alert('co id');
                divideid=localStorage.getItem("divideid");

                if(divideid.length>5){
                    divideid=(Math.random().toString(36).substring(2, 4) + Math.random().toString(36).substring(2,5)).toUpperCase();

                    localStorage.setItem("divideid",  divideid);

                }
          }
          else divideid=(Math.random().toString(36).substring(2, 4) + Math.random().toString(36).substring(2,5)).toUpperCase();



          //-------kiểm tra xem có mã chưa nếu có rồi thì thông báo
          $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
          var urll="{{ url('ajax/checkdevice_actived') }}/"+divideid;//alert(urll);
          $.ajax({
                url: urll,
                type: "GET",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);

                     
                    if(data['device_isactived']==0){
                        Swal.fire("Bạn hãy gửi mã thiết bị cho quản lý để kích hoạt thiết bị. Mã thiết bị của bạn là "+divideid);
                        localStorage.setItem("divideid", divideid);



                        //window.location.href = "{{ url('/') }}";

                    }
                    else
                    if(data['device_isactived']==-1){
                        
                        Swal.fire("Bạn hãy gửi mã thiết bị cho quản lý để kích hoạt thiết bị. Mã thiết bị của bạn là "+divideid);
                        //window.location.href = "{{ url('/') }}";

                    }
                    else {
                      //alert(data['device_orgid']);
                      // lấy org_id từ thiết bị
                      //window.location.href="{{ URL::to('survey/selectorg/')}}/"+data['device_orgid'];
                       var urll="{{ url('survey/slideresult') }}/"+data['device_orgid'];//alert(urll);
                       //alert(0);
                        //$("#kqks").prop("href",urll)
                        window.location = urll;
                      //hiện lên nút xem slide


                      //đổi tên hệ thống
                      
                    }
                },
                error:function () {//alert("NO");
                    //alert(0);
                    Swal.fire("NOO");
                    console.log("i cant's run. Please check bug!");
                }
            });

    } else {
      Swal.fire("Xin lỗi, cần nâng cấp Trình duyệt để sử dụng hệ thống");
      window.location.href = "{{ url('/') }}";

    }

    }
   
//kiemtrathietbi();
</script>

 <script>
$(document).ready(function(){
   setTimeout(function(){ 

    kiemtrathietbi();

    //window.location ="{{url('/')}}";

  }, {{($dsetting['config_time_auto_direct']*1000)}});
});
</script>

@endsection
