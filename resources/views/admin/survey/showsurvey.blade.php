@extends ('admin.layouts.index')

@section ('title')
<title>danh sách các survey được quản lý tại website</title>
@endsection
@section ('style')
<style type="text/css">
    .btn_delObj{
        color: #3490dc;
    }
    .btn_delObj:hover{
        cursor: pointer;
        color: #1D68A7;
    }
</style>
@endsection

@section ('content')
@if(session('messenger'))
  <span class='plgalertsuccess'>
   <div class="alert alert-success"><i class="fa fa-check-circle"></i>    
  {{session('messenger')}}   <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
  </span>
  @endif
  
<div class='container'> 
 
     <div class="page-header">
    <div class="container-fluid" style="padding:0px;">
      @if (isset($data['title']))
      <h1>{{$data['title']}}</h1>
      @endif  
      @if(isset($data['breadcrumbs']))
      <ul class="breadcrumb">
        <?php foreach ($data['breadcrumbs'] as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
        @endif
        
    </div>
  </div>
   
    <?php $arr=array("A","B","C","D","E","F","G","H","I","J","K","L","M");?>



   
     <form  style="padding:0px 10px 10px 20px;" action="{{url('admin/survey/surveysave')}}"   accept-charset="UTF-8" method="POST" enctype="multipart/form-data">    
    {{csrf_field()}}
    <input type='number' class='plghidden' name="topicid" value="{{$topic->topic_id}}" /> 
    <input type='number' class='plghidden' name="surveytid" value="{{$survey->survey_id}}" />
    <br>
    <?php 
    echo '<h4><span class="glyphicon glyphicon-triangle-right"></span> Chủ đề: '.$survey->Topic->topic_name.'</h4>';
    if($survey->Topic->topic_type==1)//don vi
    echo '<h4><span class="glyphicon glyphicon-triangle-right"></span> Đối tượng: '.$survey->Object_org->org_name.'</h4>';
    else
    echo '<h4><span class="glyphicon glyphicon-triangle-right"></span> Đối tượng: '.$survey->Object_us->fullname.'</h4>';
    echo '<h4><span class="glyphicon glyphicon-triangle-right"></span> Khách hàng: '.$survey->survey_customer.'</h4>';

    echo '<h4><span class="glyphicon glyphicon-triangle-right"></span> Ngày khảo sát: '.date('d-m-Y', strtotime($survey->survey_created_at)).'</h4>';

    ?>

    @foreach($question as $noques=>$ques)
 
    <div class='kquestion'>
        <br>
       <p style='padding-top: 3px;font-size: 15px;line-height: 15px;margin-bottom: 0px;float:left;'><strong>Câu {{$noques+1}}:</strong> &nbsp </p>
       <p style=' text-align: justify;font-size: 15px;line-height: 15px;float:left;'><?php echo $ques->question_description; ?></p>  

        <!-- loại 1: chọn 1 câu trả lời dùng radio box -->
        @if($ques->question_type==1)
        @foreach($answer[$noques] as $noans=>$ans)
        <?php
        //echo  $result[$noques]['result_Answer'];
        ?>
        <div class='kanswer'>
            <table class='tablequestion'>
            <td width='1%'><p><input type='radio' <?php if($result[$noques]['result_Answer']==$ans->answer_id) echo 'checked'?> value='{{$ans->answer_id}}' name='question{{$ques->question_id}}'/></p></td>
            <td class='plghidden' width='1%'><strong><p>{{$arr[$noans]}}</p></strong></td>
            <td style='text-align: justify;'><?php echo $ans->answer_description;?></td>
            </table> 
        </div>    
        @endforeach
        <!-- loại 2: chọn nhiều câu trả lời dùng checkbox -->
        @elseif ($ques->question_type==2)
        @foreach($answer[$noques] as $noans=>$ans)
        <?php
        //echo  $result[$noques]['result_Answer'];
        ?>
        <div class='kanswer'>
            <table class='tablequestion'>
            <td width='1%'><p><input type='checkbox' <?php if (in_array($ans->answer_id,json_decode($result[$noques]['result_Answer']))) echo 'checked'; ?> value='{{$ans->answer_id}}' name='question{{$ques->question_id}}[]'/></p></td>
            <td  class='plghidden' width='1%'><strong><p>{{$arr[$noans]}}</p></strong></td>
            <td style='text-align: justify;'><?php echo $ans->answer_description;?></td>
            </table> 
        </div>    
        @endforeach
        <!-- loại 3: nhập văn bản trả lời -->
        @else

        @endif

    </div>  
      
    @endforeach
    <br>
     
    </form>

    

</div> 
<style>
.glyphicon-triangle-right{
  font-size: 12px;
}
</style>
@endsection

@section ('script') 
@endsection