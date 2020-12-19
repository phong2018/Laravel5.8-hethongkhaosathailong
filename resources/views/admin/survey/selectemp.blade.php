@extends('layouts.app')

@section('content') 

<?php
session_start();
$_SESSION["orgid"] = $org['org_id'];
?>
 
 <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding:0px;padding-bottom: 10px;">
  <a style='margin-top:-80px;margin-right: 25px;' class=' btchucnangdosurvey'  href="{{ url()->previous() }}"  target="_self">
    <img src="{{url('/')}}/public/quaylai.png" class="" />
    <i class="fa fa-mail-reply plghidden" title="Quay Lại" style="border:1px solid #d26fae;;border-radius:5px;padding:5px;color:#d26fae;"></i>
  </a>
</div>



 

<div style="padding:15px;">
<div class="container containercs" style='overflow: hidden;text-align: center;border-radius: 20px;border:2px solid #f0f0f0; padding:20px 0px 50px 0px !important;  box-shadow:0px 3px 5px 5px #d0d0d0;  '>

  <h2 style="font-size:20px;padding:0px 0px 0px 0px;font-weight: bold;color:#cd0000;text-align: center;">&nbsp Quý Khách Vui Lòng Chọn Nhân viên:</h2>

@foreach($emp as $noemp=>$valemp)
<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4 khungorglv1' >
<div class="thumbselectemp khungorglv2">
<a style="text-decoration: none;" href="{{url('/survey/')}}/{{$topic->topic_id}}/{{$valemp->id}}">
<table class='bordernone'>
<td style='width:30%;padding-right: 10px;'>
<img style="width:100%" src='{{url("/")}}/public/{{$valemp->avatar}}'/>
</td><td>
<div class=' ' style='float:none;text-align: left;font-size:  20px;'>
<strong >{{$valemp->fullname}}</strong><br>
</div>
<div style="color:#3a3a3a;font-style: italic;text-align: left;padding-left: 2px;">
  Mã nhân viên: {{$valemp->ID_Staff}}<br>
  Chức danh: {{$valemp->chucdanh}}
</div>
</td></table>
</a>
</div>
</div>
@endforeach

</div></div> </div>
 
  
<style> 
 
[class*="col-"] {
  float: left  ; 
}

.khungorglv1{
  padding:7px;


}
.khungorglv2{
  border:1px solid #d0d0d0;
  padding:10px;
  border-radius: 5px;  
  overflow: hidden;
  text-align: center;
   min-height: 150px; //Sua cho nay
}
.khungorglv2 img{
  margin-bottom:5px; 
 
  }
  .imageemp{
    width:40%;
    float:left;
  }
  .nameemp{
    width:60%;
    float:left;
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
                    else 
                        if(data['device_assign_userid']>0 && data['topic_type']==2){
                            if(data['device_giaodien']==1)
                            window.location.href="{{ URL::to('survey')}}/"+data['topic_id']+"/"+data['device_assign_userid']+"/1";
                            else window.location.href="{{ URL::to('survey')}}/"+data['topic_id']+"/"+data['device_assign_userid'];

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
    
    $(".containercs").css("min-height", screen.height-$(".titleheader").height()-190);

 

  })
</script>

@endsection
