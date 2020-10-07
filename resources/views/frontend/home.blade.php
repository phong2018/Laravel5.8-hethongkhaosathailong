@extends('layouts.app')

@section('content')


 
 <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding:0px;padding-bottom: 10px;">
  <a style='margin-top:-80px;margin-right: 25px;;cursor: pointer;color: white' class=' btchucnangdosurvey' onclick="kiemtrathietbi()">
    <img src="{{url('/')}}/public/danhgia.png" class=" " />
  
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
if(!isset($dsetting['config_ks_intro_home_htks']))$dsetting['config_ks_intro_home_htks']=''; 
if(!isset($dsetting['config_time_auto_direct']))$dsetting['config_time_auto_direct']=''; 
if(!isset($dsetting['config_amthanhcamon']))$dsetting['config_amthanhcamon']=''; 
if(!isset($dsetting['config_amthanhxinchao']))$dsetting['config_amthanhxinchao']=''; 
?>
<div class="container padding0">
<img class='bannerhome' src="{{url('/')}}/public{{$dsetting['config_banner_htks']}}"  /> 

<?php echo $dsetting['config_ks_intro_home_htks'];?>

</div>

                  <audio controls autoplay="autoplay" class='plghidden'>
                  <source src="{{url('/')}}/public/{{$dsetting['config_amthanhxinchao']}}" type="audio/mpeg">
                  </audio>
 
 <script>
	 

	$(document).ready(function(){
	   setTimeout(function(){ 

	   	//window.location ="{{ URL::to('survey/selectorg/0')}}";
      kiemtrathietbi();

		}, {{($dsetting['config_time_auto_direct']*1000)}});
	  
	});
 

function kiemtrathietbi(){
  <?php if($data['config_dangkythietbidekhaosat']==1){ ?>

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
                      if(data['device_assign_userid']>0 && data['topic_type']==2){// nếu khảo sát nhaatn viên mà có mã nhân viên  
                         if(data['device_giaodien']==1)
                         window.location.href="{{ URL::to('survey')}}/"+data['topic_id']+"/"+data['device_assign_userid']+"/1";
                         else window.location.href="{{ URL::to('survey')}}/"+data['topic_id']+"/"+data['device_assign_userid'];

                      }else{
                        //alert('chọn đơn vị');
                        window.location.href="{{ URL::to('survey/selectorg/')}}/"+data['device_orgid'];
                      }
                      //đổi tên hệ thống
                      
                    }
                },
                error:function () {//alert("NO");
                    //alert(0);
                    Swal.fire("Không tìm thấy thiết bị! Liên hệ Admin để kích hoạt thiết bị. Mã thiết bị của bạn là "+divideid);
                    console.log("i cant's run. Please check bug!");
                }
            });

    } else {
      Swal.fire("Xin lỗi, cần nâng cấp Trình duyệt để sử dụng hệ thống");
      window.location.href = "{{ url('/') }}";

    }

    
  <?php }else{ ?>
    
    window.location.href="{{ URL::to('survey/selectorg/0')}}";

  <?php } ?>
}

</script>
 


@endsection
