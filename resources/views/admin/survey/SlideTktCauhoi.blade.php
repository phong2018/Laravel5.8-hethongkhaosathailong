@extends('layouts.app')

@section('content')

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

<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding:0px;padding-bottom: 10px;">
  <a style='margin-top:-80px;margin-right: 25px;' class=' btchucnangdosurvey' href="{{url('/')}}">
    <img src="{{url('/')}}/public/batdaulai.png" class="" />
    <i class="fa fa-mail-reply plghidden" title="Quay Lại" style="border:1px solid #d26fae;;border-radius:5px;padding:5px;color:#d26fae;"></i>
  </a>
</div>




@if(session('messenger'))
  <span class='plgalertsuccess'>
   <div class="alert alert-success"><i class="fa fa-check-circle"></i>    
  {{session('messenger')}}   <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
  </span>
  @endif
  
<div class='container' style="background: white;">


<div class="container">
    <div class="container-fluid ">


     
 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Hài lòng',     <?php echo $data['ans0'];?>],
          ['Bình thường',       <?php echo $data['ans1'];?>],
          ['Không hài lòng',   <?php echo $data['ans2'];?>], 
        ]);

        var options = {
          title: ' '
        };
       
            

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
 
    <div id="piechart" style="width: 100%; height: 500px; "></div>
 







          
            <ul class="nav nav-tabs plghidden">
  <li><a style='cursor: pointer;' class='tbieudo' data-toggle="tab"  onclick="hientab('#chartexcel','#bd0')" id="bd0" >Biểu đồ 1</a></li>
  <li><a style='cursor: pointer;' class='tbieudo' data-toggle="tab"  onclick="hientab('#charttheonhanvien','#bd1')" id="bd1" >Biểu đồ 1</a></li>
  <li><a style='cursor: pointer;' class='tbieudo'data-toggle="tab" onclick="hientab('#chartdiemtheocau','#bd2')" id="bd2" >Biểu đồ 2</a></li>
  <li><a style='cursor: pointer;' class='tbieudo' data-toggle="tab" onclick="hientab('#chartdiemtheodapan','#bd3')" id="bd3">Biểu đồ 3</a></li>
</ul>
       
    </div> 
<div style="padding:15px;"> 
    
 
  <div id="chartexcel"  class="bdthongke col-md-12 col-lg-12 col-xs-12">
      <div class="row justify-content-center">      
 
 
    <div class="col-md-12 col-lg-12 col-xs-12">
  <div class="container" >
  

  </div>
  </div>
</div>


  </div> 
   <div id="chartdiemtheodapan" style='text-align: center;'  class="bdthongke  col-md-12 col-lg-12 col-xs-12"></div>
<div style="width:100%;text-align: center;">
   <i onclick="chayslide(0)" title='Tạm dừng' class="chayslide fa fa-pause-circle-o"></i>

   <i onclick="chayslide(1)" title='Chạy Slide' class="chayslide fa fa-play-circle-o"></i>
</div> 
</div> 
   </div>

<style>
  .chayslide{
    font-size: 30px;
    color:blue;
  }
  #charttheonhanvien img{ }
  #chartdiemtheocau img{ }
</style>
 

</div>

<style type="text/css">
  .bdthongke  img{width: 100%;}
  
</style>
<script type="text/javascript">
   


  
  function hientab(id,idt){
  
  }


</script>



<script type="text/javascript">
  var pau=0;
    $(document).ready(function(){
   
    //$('#anlucdau').css("display", "none");

   
    setTimeout(function(){  hientab('#chartexcel','#bd0'); }, 500);
    var co=0;
    
    setInterval(function(){ 
      if(pau==0){
        if(co%4==0) hientab('#chartexcel','#bd0');
        if(co%4==1) hientab('#charttheonhanvien','#bd1');
        if(co%4==2) hientab('#chartdiemtheocau','#bd2');
        if(co%4==3) hientab('#chartdiemtheodapan','#bd3');
        co++;
      }
    }, 3000);

  

    
    //$("#anlucdau").css("min-height", screen.height-$(".titleheader").height()-300);




  });

    $('.fa-play-circle-o').css("display", "none");

    function chayslide(va){
      
        pau=va;
        $('.chayslide').css("display", "none");

        if(pau==1){
          $('.fa-pause-circle-o').css("display", "block");
          pau=0;
          
        }
        else{
          $('.fa-play-circle-o').css("display", "block");
          pau=1;
          
        }
    }




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
                      if(data['device_assign_userid']>0 && data['topic_type']==2){// nếu khảo sát nhaatn viên mà có mã nhân viên 
                        if(data['device_giaodien']==1)
                        window.location.href="{{ URL::to('survey')}}/"+data['topic_id']+"/"+data['device_assign_userid']+"/1";
                        else window.location.href="{{ URL::to('survey')}}/"+data['topic_id']+"/"+data['device_assign_userid'];

                      }else
                      window.location.href="{{ URL::to('survey/selectorg/')}}/"+data['device_orgid'];
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

 
}

</script>


 <script>
$(document).ready(function(){


 
    checkaction=1;
    document.onkeypress = function (e) {
       checkaction=1;
     
    };
    document.body.onmousedown = function() { 
       checkaction=1;
    }

 

   setInterval(function(){ 

    //kiemtrathietbi();
    if(checkaction==0)
    kiemtrathietbi(); 

    checkaction=0;

  }, {{($dsetting['config_time_auto_direct']*1000)}});
});
</script>


<style type="text/css">
#anlucdau{
    overflow: hidden; border-radius: 20px;border:2px solid #f0f0f0; padding:20px 0px 50px 0px !important;  box-shadow:0px 3px 5px 5px #d0d0d0;  
  }


.bdthongke img{ 
  margin:auto;
}
</style>
@endsection

@section ('script')
<script> 
 function getobject(topicid){
  $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    if(topicid>0){
    var urll="{{ url('admin/ajax/Object_getobject/') }}/"+topicid;//alert(urll);
    $.ajax({
        url: urll,
        type: 'GET', 
        dataType: "JSON",
        data: {},
        success: function (response)
        {
            //alert('YES');
            $("#survey_idObject").empty();//To reset cities
            $("#survey_idObject").append("<option value=''>Tất cả</option>");
            var val=response['object']; 
            var sl="";
            if(response['topic_type']==1)// đơn vị
            for(i=0;i<val.length;i++){
              if(val[i]['org_id']=={{$data['filter_survey_idObject']}})   sl="selected";
              else     sl="";     

              $("#survey_idObject").append("<option value="+val[i]['org_id']+" "+sl+"  >"+val[i]['org_name']+"</option>");
            }
            else// nhân viên
            for(i=0;i<val.length;i++){
              if(val[i]['id']=={{$data['filter_survey_idObject']}})   sl="selected";
              else     sl="";  


              $("#survey_idObject").append("<option value="+val[i]['id']+"   "+sl+">"+val[i]['fullname']+"</option>");
            }

            //=========
            //alert('YES');
            $("#survey_idorglv1").empty();//To reset cities
            $("#survey_idorglv1").append("<option value=''>Tất cả</option>");
            var val=response['orglv1']; 
            var sl=""; 
            for(i=0;i<val.length;i++){
              if(val[i]['org_id']=={{$data['filter_survey_idorglv1']}})   sl="selected";
              else     sl="";     

              $("#survey_idorglv1").append("<option value="+val[i]['org_id']+" "+sl+"  >"+val[i]['org_name']+"</option>");
            } 
             
             
        },
        error: function(xhr) {
             Swal.fire('NO');
            console.log(xhr.responseText);  
       }
    });
    }
 }

 //getobject({{$data['filter_survey_topic_id']}})
 //https://www.w3schools.com/howto/howto_css_skill_bar.asp
 //https://www.w3schools.com/howto/howto_google_charts.asp
</script>



<style>
.svresult{
  width:  100%;
}
.containerbar {
  width: 100%;
  background-color: #ddd; 
  color: black;
}

.skillsbar {
  text-align: right;
  padding-top: 2px;
  padding-bottom: 0px;
  color: black;
  background:red;
  height:20px;
  font-size: 12px;
}
.widthkq{
  width:200px;
}
</style>


@endsection