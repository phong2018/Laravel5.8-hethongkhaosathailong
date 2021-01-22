@extends ('admin.layouts.index')
@section ('title')
<title>danh sách các survey được quản lý tại website</title>
@endsection
@section ('style')
<style type="text/css"> 
</style>
@endsection
@section ('content')

<?php 
?>



    @if(session('messenger'))
    <span class='plgalertsuccess'>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i>    
    {{session('messenger')}}   <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    </span>
    @endif 
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
    <div class="container-fluid1">
        <form method="GET" action="" enctype="multipart/form-data" style="padding-bottom: 10px;">    
        <div class="col-sm-4">
        <div class="form-group">
        <label class="control-label" for="input-topic_id">
            <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn chủ đề khảo sát.">Chọn Chủ đề</span>
        </label>

        <select id="topic_id"  onchange="getobject(this.value)"   name="filter_survey_topic_id" class="form-control{{ $errors->has('topic_id') ? ' is-invalid' : '' }}">
                
                <option value="0">Chọn chủ đề</option>
            @foreach($data['topics'] as $topic)
                <option 
                @if ($data['filter_survey_topic_id']==$topic->topic_id)
                selected
                @endif
                value="{{$topic->topic_id}}">{{$topic->topic_name}}</option>
            @endforeach 
        </select>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="form-group">
        <label class="control-label" for="input-survey_idorglv1">
            <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Đơn vị.">Chọn Đơn vị</span>
        </label>

        <select id="survey_idorglv1"    name="filter_survey_idorglv1" class="form-control{{ $errors->has('survey_idorglv1') ? ' is-invalid' : '' }}">
                <option value="0">Tất cả</option>
            
        </select>
        </div>
        </div>

        <div class="col-sm-3 plghidden">
        <div class="form-group">
        <label class="control-label" for="input-survey_idObject">
            <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn chủ đề khảo sát.">Chọn Đối tượng</span>
        </label>

        <select id="survey_idObject"    name="filter_survey_idObject" class="form-control{{ $errors->has('survey_idObject') ? ' is-invalid' : '' }}">
                <option value="0">Tất cả</option>
            
        </select>
        </div>
        </div>

        <div class="col-sm-4">
        <div class="form-group">
        <label class="control-label "  for="input-ngaykhaosat">
            <span data-toggle="tooltip" data-container="" title="" data-original-title="Thống kê theo ngày khảo sát (từ ngày-> đến ngày). Tick chọn để thống kê theo ngày khảo sát.">Ngày khảo sát</span>

        <input type="checkbox" name="filter-input-ngaykhaosat" 
            @if ( $data['filter-input-ngaykhaosat']==1)
        checked
        @endif
        value="1">    
        </label>
        <div class="col-md-12 padding0">
        <div class="col-md-6 col-sm-6 padding0" style='padding-right:10px; '>
        <input style='width:100%' id="filter_ngaykhaosat_tungay" type="date" class="typedate" value="{{$data['filter_ngaykhaosat_tungay']}}" name="filter_ngaykhaosat_tungay" >
        </div>
        <div class="col-md-6  col-sm-6 padding0"  style='padding-right:10px;'>
        <input style='width:100%' id="filter_ngaykhaosat_denngay" type="date" class="typedate" value="{{$data['filter_ngaykhaosat_denngay']}}" name="filter_ngaykhaosat_denngay" >
        </div>
        </div>
        </div>
        </div>
        <div class="col-sm-12">
        <div class="form-group">
        <table class='pull-left  bordernone '>
        <td>
        </td><td>&nbsp </td>
        </table>
        <table class='pull-right bordernone '>

        <tr><td style="padding-top: 5px;"> 
        <a class='btn btn-primary' href="{{ route('survey.updatemucdohailong')}} " href="survey/updateMucdoHailong">Cập nhật Khảo sát</a>
        <button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> Thống Kê</button> 
        </td><td >&nbsp </td><td style="padding-top: 5px;" class=' '>
        <button type="submit" name="xuatexcel" class="btn btn-primary">  <i style="" class="fa fa-file-excel-o" aria-hidden="true"></i> Xuất Excel</button> 
        </td></tr>
        </table>
        <br><br> 
        </div>
        </div>

        </form>
    </div>
    <!-- ------->
    <div class="col-md-12 col-lg-12 col-xs-12">
        <div class="container"> 
            <!-- ---->
            <ul class="nav nav-tabs"> 
                <?php 
                if(isset($data['arr_body']))
                for($i=0;$i<count($data['arr_body']);$i++)
                    if($i==0) echo '<li class="active"><a data-toggle="tab" href="#menu'.($i+1).'">Câu '.($i+1).'</a></li>';
                    else echo '<li><a data-toggle="tab" href="#menu'.($i+1).'">Câu '.($i+1).'</a></li>';
                ?> 
            </ul>

            <div class="tab-content">
                <?php 
                if(isset($data['arr_body']))
                for($i=0;$i<count($data['arr_body']);$i++){
                ?>
                    <div id="menu<?php echo ($i+1);?>" class="tab-pane fade <?php if($i==0) echo 'in  active';?>">
                        <table   style="width:100%"><tr><td  >
                        <?php 
                        echo '<table border="1" style="width:100%"><tr>';
                        foreach ($data['arr_body'][$i] as $no1 => $val1) {
                            $w="style='width:".(100/($data['maxAns']+1))."%;vertical-align:top';"; 
                            echo "<td ".$w.">".$val1."</td>";
                        }
                        echo '</tr></table>';
                        ?>
                        </td></tr><tr><td style="overflow:hidden"> 
                          
                        
                        <div id="piechart<?php echo $i?>" style="width: 800; height: 400px;text-align:center"></div>

                        </td></tr></table>
                    </div>
                   
                <?php  } ?> 
                

            </div>
        </div>
    </div> 
    <!-- ------->
@endsection
@section ('script')  


<script type="text/javascript" src="{{url('/')}}/public/plg/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        <?php 
        if(isset($data['arr_body']))
        for($i=0;$i<count($data['arr_body']);$i++){
        ?>
            var data<?php echo $i?> = google.visualization.arrayToDataTable([
            [' ', ' '],
            <?php for($j=0;$j<count($lava[$i]);$j++){ ?>
            ['<?php echo $lava[$i][$j][0];?>', <?php echo number_format($lava[$i][$j][1],1);?> ],
            <?php } ?>
            ]); 

            var options<?php echo $i?> = {
            title: ' ',
            width: 800,
            height: 400,    
            pieSliceText:'none', 
            
            };

 
            
            var chart<?php echo $i?> = new google.visualization.PieChart(document.getElementById('piechart<?php echo $i?>'));

            chart<?php echo $i?>.draw(data<?php echo $i?>, options<?php echo $i?>);
 
            temp= $("#piechart<?php echo $i?> g > text").html();

            console.log(temp,"=============");
            
        <?php } ?>
      }
     
    </script>
  </head>
  
    
 



<style>

#piechart1 text{
    margin-right: 20px !important;
}


.canvasjs-chart-credit{
    display: none;
}
.canvasjs-chart-container{
    text-align: center !important;
}
canvas{
    position: relative !important;
}
.tab-content{
    min-height: 300px;
}
.svresult{
  width:  100%;
}
.hdes{
   
}
.containerbar {
  width: 100%;
  background-color: #ddd; 
  color: black;
}

.skillsbar { 
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
            $("#survey_idObject").empty();//To reset cities
            $("#survey_idObject").append("<option value=''>Tất cả</option>");
            var val=response['object']; 
            var sl=""; 
            for(var i=0;i<val.length;i++){
              if(val[i]['org_id']== {{$data['filter_survey_idObject']}} )   sl="selected";
              else sl="";     

              $("#survey_idObject").append("<option value="+val[i]['org_id']+" "+sl+"  >"+val[i]['org_name']+"</option>");
            } 
            //========= 
            $("#survey_idorglv1").empty();//To reset cities 
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

 $(document).ready(function(){
  <?php $temptopic=$data['topics'];?>
  <?php
  if($temptopic!=null)
  foreach($temptopic as $t)
  echo "var topicchon=".$t->topic_id.";";
  ?>
  
  getobject(topicchon);

});
</script>
@endsection