 
  <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	 <!--
	 <script src="{{ asset('public/js/app.js') }}" ></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
	 -->
	@yield ('title')
	<link href="<?php echo e(asset('/public/css/all.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('/public/css/font-awesome.min.css')); ?>" rel="stylesheet">
	 
	@yield ('style')
	<script src="<?php echo e(asset('/public/js/jquery.min.js')); ?>"></script>
	<link rel="shortcut icon" href="{{url('/')}}/public/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo e(asset('/public/css/bootstrap.min.css')); ?>">  
	<script src="<?php echo e(asset('/public/js/bootstrap.min.js')); ?>"></script>
	<link href="<?php echo e(asset('/public/plg/stylesheet/stylesheet.css')); ?>" rel="stylesheet">
	<script src="<?php echo e(asset('/public/plg/common.js')); ?>"></script>
	<link href="<?php echo e(asset('/public/css/custom.css')); ?>" rel="stylesheet"> 
</head>
<body>
<div class='container'> 

   
    <?php $arr=array("A","B","C","D","E","F","G","H","I","J","K","L","M");?>



   
     <form  style="padding:0px 10px 10px 20px;" action="{{url('admin/survey/surveysave')}}"   accept-charset="UTF-8" method="POST" enctype="multipart/form-data">    
  
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
       <p style='padding-top: 3px;font-size: 15px;line-height: 15px;margin-bottom: 0px;float:left;'><strong>Câu {{$noques+1}}:</strong>  </p>
       <p style=' text-align: justify;font-size: 15px;line-height: 15px;float:left;'><?php echo str_replace("&nbsp","",$ques->question_description); ?></p>   

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
 </body>
 </html>