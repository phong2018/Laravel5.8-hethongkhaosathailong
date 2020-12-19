
@extends('layouts.app')

@section('content') 


<?php
session_start();
//echo $_SESSION["orgid"];
?>
 <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style="padding:0px;padding-bottom: 10px;">
  <a style='margin-top:-80px;margin-right: 25px;' class=' btchucnangdosurvey'  href="{{ url()->previous() }}"  target="_self">
    <img src="{{url('/')}}/public/quaylai.png" class="" />
    <i class="fa fa-mail-reply plghidden" title="Quay Lại" style="border:1px solid #d26fae;;border-radius:5px;padding:5px;color:#d26fae;"></i>
  </a>
</div>
 


<div class="container">
 <h2 class='plghidden' style="padding-top: 10px;"> {{$topic->topic_name}} {{$data['nameob']}} </h2>
</div>
<div style="padding:15px;">
<div class="container containercs" style="overflow: hidden; border-radius: 20px;border:2px solid #f0f0f0; padding:20px 0px 50px 0px !important;  box-shadow:0px 3px 5px 5px #d0d0d0;  ">

   
    <h3>
       
    </h3>
   
    <?php $arr=array("A","B","C","D","E","F","G","H","I","J","K","L","M");?>

<!-- onsubmit="return validateForm()" -->
   
     <form  style="padding:0px;border: 0px" action="{{url('survey/surveysave')}}"   accept-charset="UTF-8" method="POST"  enctype="multipart/form-data">    
    {{csrf_field()}}
    <input type='number' class='plghidden' name="topicid" value="{{$topic->topic_id}}" />
    <input type='number' class='plghidden' name="objectid" value="{{$objectid}}" />
    <input type='number' class='plghidden' name="surveytid" value="{{$survey->survey_id}}" />
    <input type='number' class='plghidden' id="orgidlv1" name="survey_idorglv1" value="" />
    
    <div id='infonv' class="col-xs-12 col-sm-12 col-md-12 col-lg-12 khunghinhnvks" style="padding-bottom: 20px;" >
        <span id='if1'>
          <img style="width: 100%;padding:5px 5px 5px 5px;" src="{{url('/')}}/public{{$data['thumbob']}}"/>
          <span style="font-weight: bold;color:#3490dc;font-size: 20px;">{{$data['nameob']}}</span></br>
          <span style="font-style: italic;color:#3a3a3a;font-size: 15px;">{{$data['infoob']}}</span><br>
          <span style="font-style: italic;color:#3a3a3a;font-size: 15px;">{{$data['infoob1']}}</span>
        </span>
        <span id='if2'>
          <table class='col-xs-12 col-sm-12 col-md-6 col-lg-6' style='margin:auto;float:none;' ><td style='text-align: center;width:30%'>
          <img style="width: 100%;padding:5px 5px 5px 5px;" src="{{url('/')}}/public{{$data['thumbob']}}"/>
          </td><td style='text-align: center;'>
            <div>
              <span style="font-weight: bold;color:#3490dc;font-size: 20px;">{{$data['nameob']}}</span></br>
              <span style="font-style: italic;color:#3a3a3a;font-size: 15px;">{{$data['infoob']}}</span><br>
              <span style="font-style: italic;color:#3a3a3a;font-size: 15px;">{{$data['infoob1']}}</span>
             </div> 
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='margin-top: 5px;'>
              <table style='margin-top: -10px;'><td> 
              <span style="float:right;margin-top: 12px;margin-right:   -10px;">Thông tin KH</span>
              </td><td><i class="fa fa-keyboard-o" id='hienankeyboard' style="font-size:30px;margin-top: 15px;margin-left:10px;"></i></td>
              </table>

                <input class='nsdtbn' id='ttkh' style='  margin-bottom: 20px;width: 100% ' type='text' placeholder="Nhập tên, số biên nhận, số xe hoặc số điện thoại" name='customer'   /> 
                <input type="hidden" id="idcheckkhonghailong" name="checkkhonghailong" value="0">
              </div>
            </td></table>
            <div style='margin-top: 0px !important' id="keyboard"></div>
        </span>
    </div>
    <div  id='khungks' class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 0px;">
    <?php $cc=0;?>
    @foreach($question as $noques=>$ques)
    <?php $cc++;?>
 
 
    <div class='kquestion' style="overflow: hidden;font-weight: bold;">
      <div  class='cochucauhoi'> 
       <p  class='nocauhoi'  style='  line-height: 15px;margin-bottom: 0px;float:left;'><strong>Câu {{$noques+1}}:</strong> &nbsp </p>
       <p style=' text-align: justify; line-height: 15px;float:left;'><?php echo $ques->question_description; ?></p>  
      </div>
        <!-- loại 1: chọn 1 câu trả lời dùng radio box -->
        @if($ques->question_type==1)
        @foreach($answer[$noques] as $noans=>$ans)
        <div class='kanswer'  id="ques{{$noques}}" style="padding-left:20px;font-weight:normal;width:<?php echo (100/count($answer[$noques]));?>%;float:left";>
            <table class='tablequestion' onclick="chonans({{$noques}},{{$noans}},{{$cc}},<?php echo "'".rtrim(html_entity_decode(strip_tags($ans->answer_description)))."'";?>)">
            <td width='1%'> 
                <label class="containerrdob" style="margin-top:-17px;"> 
                  <input id="ques{{$noques}}ans{{$noans}}" type='radio' value='{{$ans->answer_id}}' name='question{{$ques->question_id}}'/>
                  <span class="checkmarkrdob"></span>
                </label>
            </td>
            <td class='plghidden' width='1%'><strong><p>{{$arr[$noans]}}</p></strong></td>
            <td id="ques{{$noques}}ans{{$noans}}-des" class='des-ans' style=' '><?php echo $ans->answer_description;?></td>
            </table> 
        </div>    
        @endforeach
        <!-- loại 2: chọn nhiều câu trả lời dùng checkbox -->
        @elseif ($ques->question_type==2)
        @foreach($answer[$noques] as $noans=>$ans)
        <div class='kanswer'  id="ques{{$noques}}ans{{$noans}}-div" style="padding-left:40px;font-weight:normal;">
            <table class='tablequestion' onclick="chonans({{$noques}},{{$noans}},{{$cc}},<?php echo "'".rtrim(html_entity_decode(strip_tags($ans->answer_description)))."'";?>)">
            <td width='1%'><p><input id="ques{{$noques}}ans{{$noans}}" type='checkbox' value='{{$ans->answer_id}}' name='question{{$ques->question_id}}[]'/></p></td>
            <td  class='plghidden' width='1%'><strong><p>{{$arr[$noans]}}</p></strong></td>
            <td style=' '><?php echo $ans->answer_description;?></td>
            </table> 
        </div>    
        @endforeach
        <!-- loại 3: nhập văn bản trả lời -->
        @else

        @endif

    </div>  
      
    @endforeach
    <div class="col-md-12 padding0">
        <div class="col-md-12 padding0" style='text-align: left;padding-top: 30px;'>
          <div class="col-xs-12 col-sm-2 col-md-2 col-lg-3" style=' '> 
            
            
            

          </div>
           <div class="col-xs-12 col-sm-4 col-md-4 col-lg-5" style='margin-top: 5px;'>

              
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
           <table  style="float:right;width:100%">
            <td>
            
            </td>
            <td>
            <div  id='btlamlai'   onclick="resetchon()" class="btn btn-warning" style=' margin-left: 0px !important;float:right; background: white;border: none;'>
                <img src="{{url('/')}}/public/lamlai.png" style="width:100px;" />

            </div>
            </td><td>
             <button type="submit" id="luulai" class="btn btn-warning" style=' margin-left: 0px !important;float:right; background: white;border: none;'>
                
               <img src="{{url('/')}}/public/guidanhgia.png" style="width:150px;" />
            </button>
            </td></table>

<style type="text/css">
  

/*Ipad*/
@media only screen and (max-width : 1024px) {
   #btlamlai, #luulai{
     margin-top: -10px;
   }
   .cochucauhoi{
    font-size: 15px;
   }
}

</style>
          </div>

        </div>
    </div>

     
    
    <script>

       function kiemtrarotchucamon(){
          var hkhungks=$("#khungks").height();
          var hkhungifo=$("#infonv").height();

          //alert(hkhungks+'-'+hkhungifo);

          if(hkhungks<hkhungifo){
            $("#khungvuilong2").hide();
            $("#khungvuilong1").show();
          }else{
            $("#khungvuilong1").hide();
            $("#khungvuilong2").show();

          }

        }


        $('#keyboard').jkeyboard({
            layout: "english",
            input: $('#ttkh'),
           
        });
        //=========
         $("#keyboard").hide();
         $(document).ready(function(){
          $("#hienankeyboard").click(function(){
 
            $("#keyboard").toggle();

            kiemtrarotchucamon();
          });
        });
    </script>
<div id='khungvuilong1' style=' font-size: 22px;padding-top:30px;text-align: center;width: 100%;font-weight: bold;overflow: hidden;color:blue'> 
    Vui lòng đánh giá để giúp chúng tôi hoàn thiện hơn. Xin cám ơn.</div>

    </div>     

<div id='khungvuilong2' style=' font-size: 22px;padding-top:30px;text-align: center;width: 100%;font-weight: bold;overflow: hidden;color:blue'> 
    Vui lòng đánh giá để giúp chúng tôi hoàn thiện hơn. Xin cám ơn.</div>
 
    
  </div>     
</div>  
    
    
    </form>

              <audio id="amthanhcamcon" controls   class='plghidden'>
              <source src="{{url('/')}}/public/{{$data['config_amthanhcamon']}}" type="audio/mpeg">
              </audio>

<style type="text/css">
    .tablequestion{cursor: pointer;}
</style>
<script>
var countplay=0;
var arrcheckans=[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];
function resetchon(){
     $("input").prop("checked", false);
}
function chonans(noques,noans,cc=0,dapans=""){
    //noques++;noans++;
    var id="#ques"+noques+"ans"+noans;
    //alert(id);
    $(id).prop("checked", true);
    //==========
    var idqes="#ques"+noques+" .des-ans";
    $(idqes).css({"font-weight": "normal", "color": "black"});


    var idquesansdes="#ques"+noques+"ans"+noans+"-des";
    $(idquesansdes).css({"font-weight": "bold", "color": "blue"});

    dapans = dapans.toLowerCase();
    if(dapans.includes("bình thường") || dapans.includes("không hài")){
        arrcheckans[cc]=0;  
        //alert(dapans);
    }
    else arrcheckans[cc]=1;  
    
}
$(document).ready(function(){
    checkaction=1;
    checkkhongclicksave=1;
    checkcokhonghailong=0;
    document.onkeypress = function (e) {
       checkaction=1;
     
    };
    document.body.onmousedown = function() { 
       checkaction=1;
    }

    setInterval(function(){ 
      //alert(checkaction);
      if(checkaction==0){
            // nếu làm chưa đủ câu hỏi thì ko lưu và nhảy qua trang home/ sẽ có cơ chế xóa bài kiểu khác
            if($('input:radio:checked').length<{{count($question)}}){


              // resetchon();
                 
                
                if(screen.width<1024)// nếu là ipad thì khỏi chuyển màn hình
                   resetchon();
                else
                  window.location ="{{url('survey/deletesuveyfail/')}}/{{$survey->survey_id}}/{{$data['orgid']}}";    
               

            }
            // cho xóa ở đay luôn đi// cho gọi hàm xóa luôn rồi redicre
           
            //document.getElementById("luulai").click();// xóa khi luu kiểm tra ko đủ đáp án thì xóa  
            //window.location ="{{url('/')}}";    
            else
            if(checkkhongclicksave==1)
            document.getElementById("luulai").click();
      }
      else checkaction=0;

    },{{($data['config_time_auto_direct']*1000)}});

    $('#navbarDropdown').hide();

 


});
function validateForm(){
    //alert(9);
    if($('input:radio:checked').length<{{count($question)}}){
        //alert("Quý khách chưa đánh giá đủ các câu hỏi, vui lòng đánh giá tiếp!");
        return false;
    }else return true;


}

function checkdanhgiakhonghailong(){
   for(i=1;i<arrcheckans.length;i++)
   if(arrcheckans[i]==0){
       //alert('co ko hai long');
       $("#idcheckkhonghailong").val(1);
       return true;

   }
   $("#idcheckkhonghailong").val(0);
   return false;
}

//delay sumbmit
$('form').submit(function (e) {
    if($('input:radio:checked').length>={{count($question)}}){
        if(countplay==0){
            countplay++;
            document.getElementById('amthanhcamcon').play();
        }
    }
    else  Swal.fire("Quý khách chưa đánh giá đủ các câu hỏi, vui lòng đánh giá tiếp!");

     
    var form = this;
    e.preventDefault();

    setTimeout(function () {
      
      if($('input:radio:checked').length=={{count($question)}} && $("#ttkh").val()=="" && checkdanhgiakhonghailong()){
        checkkhongclicksave=0;
        (async () => {
            //alert('chaylai:'+khongchaylai);
            const { value: formValues } = await Swal.fire({
              title: 'Quý khách vui lòng cung cấp thông tin để chúng tôi hỗ trợ',
              timer: {{($data['config_time_auto_direct']*1000)}}*10,
              confirmButtonText:'Gửi',
              html:
                '<input id="swal-input1" placeholder="Họ tên" class="swal2-input">' +
                '<input id="swal-input2" placeholder="Số điện thoại" class="swal2-input">' +
                '<input id="swal-input3" placeholder="Thông tin khác (số biên nhân, số căn cước...)" class="swal2-input">' 
                ,
              focusConfirm: false,
              preConfirm: () => {
               //alert(1);
                return [
                  document.getElementById('swal-input1').value,
                  document.getElementById('swal-input2').value,
                  document.getElementById('swal-input3').value,
                ]
              },
              onClose: () => {
                //alert(2);
                form.submit();
              }
            })

            if (formValues) {
              //alert(JSON.stringify(formValues));
              arr=JSON.parse(JSON.stringify(formValues));
              //alert(arr[0]+"; "+arr[1]+"; "+arr[2]);
              if(arr[0]!="" || arr[1]!="" || arr[2]!="")
              $("#ttkh").val(arr[0]+"; "+arr[1]+"; "+arr[2]);
            }
            
            if(validateForm())
            form.submit();
          })()
      }
      else 
      if(validateForm())
            form.submit();

    }, 1); // in milliseconds
     
});


</script>

 <style>
    ::placeholder {
  color: #bc0c0c0;
  font-size: 12px;
} 
/* The containerrdob */
.containerrdob {
  display: block;
  position: relative;
  padding-left: 25px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.containerrdob input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmarkrdob {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.containerrdob:hover input ~ .checkmarkrdob {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.containerrdob input:checked ~ .checkmarkrdob {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmarkrdob:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.containerrdob input:checked ~ .checkmarkrdob:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.containerrdob .checkmarkrdob:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
}
</style>         

<script type="text/javascript">
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
                    else{
                      //alert('do');
                      // kiểm tra màn hình dọc
                      // cập nhật Đơn vị cho survey, khảo sát của Đơn vị nào
                      $('#orgidlv1').val(data['device_orgid']);

                      if(data['device_giaodien']==1){// mà hình dọc
                        //alert('giao dien doc');
                        //$('#infonv').removeClass("col-xs-4 col-sm-4 col-md-3 col-lg-3");
                        //$('#infonv').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-12");
                        //$('#khungks').removeClass("col-xs-8 col-sm-8 col-md-9 col-lg-9");
                        //$('#khungks').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-12");

                        $(".kanswer").css("padding-left", "0px");
                        //$("#ttkh").css("margin-top", "-55px");
                        $("#if1").hide();
                        $("#if2").show();
                      }
                      else{
                        $("#if1").show();
                        $("#if2").hide();
                      }

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

  kiemtrarotchucamon();
</script>

@endsection
