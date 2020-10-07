aaaa
@extends('layouts.app')

@section('content') 
 
 
  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding:0px;padding-bottom: 10px;">
  <a style='margin-top:-82px;margin-right: 25px;' class=' btchucnangdosurvey'  href="{{ url()->previous() }}"  target="_self">
    <img src="{{url('/')}}/public/quaylai.png" class="hidden-xs hidden-sm " />
    <i class="fa fa-mail-reply hidden-md hidden-lg" title="Quay Lại" style="border:1px solid #d26fae;;border-radius:5px;padding:5px;color:#d26fae;"></i>
  </a>
</div>
 



<div style="padding:15px;">
<div class="container containercs" style="overflow: hidden;text-align: center;border-radius: 20px;border:2px solid #f0f0f0; padding:20px 0px 50px 0px !important;  box-shadow:0px 3px 5px 5px #d0d0d0;  ">


 <h2 style="font-size:20px;padding:0px 0px 20px 0px;font-weight: bold;color:#cd0000;text-align: center;">&nbsp Quý Khách Vui Lòng Chọn Bộ Phận:</h2>
 
@foreach($org as $no=>$val)
@if(count($emp[$no])>0)


<div class='col-xs-6 col-sm-4 col-md-3 col-lg-3 khungorglv1 ' <?php if($no==0) echo 'style="display:block;margin:auto;"'; ?> >
<div id="flip{{$no}}" class='khungorglv2' style="min-height: 200px;">
    <a href="{{ URL::to('survey/selectemp/')}}/{{$val->org_id}}" style='text-decoration: none;font-size:  16px'>
      <img class='thumbemp' style="margin:auto;width:50%" src='{{url("/")}}/public/{{$val->org_image}}'/><br>    

{{$val->org_name}}</a>
</div>
</div> 
@endif
@endforeach
<script> 
 

</script>
<style> 
 
[class*="col-"] {
  float: left  ; 
}
.khungorglv1{
  padding:15px;
  display: inline-block;
  float:none;
}
.khungorglv2{
  border:1px solid #d0d0d0;
  padding:15px;
  border-radius: 5px; 
  min-height: 230px;
  text-align: center;
}
.khungorglv2 img{
  margin-bottom:5px; 
  }
 </style>
 <script type="text/javascript">
  $('#navbarDropdown').hide();

    <?php if($data['config_dangkythietbidekhaosat']==1){ ?>

    var divideid;
    // Check browser support
    if (typeof(Storage) !== "undefined") {
          
          // Retrieve
          if(localStorage.getItem("divideid")){
                //alert('co id');
                divideid=localStorage.getItem("divideid");
          }
          else divideid=(Math.random().toString(36).substring(2, 16) + Math.random().toString(36).substring(2, 16)).toUpperCase();
          //-------kiểm tra xem có mã chưa nếu có rồi thì thông báo
          $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
          var urll="{{ url('ajax/checkdevice_actived') }}/"+divideid;//alert(urll);
          $.ajax({
                url: urll,
                type: "GET",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);
                     
                    if(data['device_isactived']==0){
                        Swal.fire("Xin lỗi, Thiết bị này chưa được quản lý để thực hiện khảo sát");
                        window.location.href = "{{ url('/') }}";

                    }
                    else
                    if(data['device_isactived']==-1){
                        Swal.fire("Xin lỗi, Thiết bị đã bị tắt chức năng thực hiện khảo sát");
                        window.location.href = "{{ url('/') }}";

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

  <?php } ?>


</script>
 

<script type="text/javascript">

  $(document).ready(function(){

    
    $(".containercs").css("min-height", screen.height-$(".titleheader").height()-200);
  })
</script>

@endsection
