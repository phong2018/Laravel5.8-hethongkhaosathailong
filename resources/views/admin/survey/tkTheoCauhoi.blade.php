@extends ('admin.layouts.index')
@section ('title')
<title>danh sách các survey được quản lý tại website</title>
@endsection
@section ('style')
<style type="text/css"> 
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
            <div  class=" " style=" overflow-x: auto;">
            <h2 class='pdT15 pdB15'>Kết quả thống kê theo câu hỏi</h2>
            <h4>Tổng số lượt khảo sát: {{$data['slThongke']}}</h4>
            <table class='table bdcl'>
                <?php 
                for($i=0;$i<count($data['arr_body']);$i++){
                    echo '<tr>';
                    foreach ($data['arr_body'][$i] as $no1 => $val1) {
                        $w="style='width:".(100/($data['maxAns']+1))."%';"; 
                        echo "<td ".$w.">".$val1."</td>";
                    }
                    echo '</tr>';
                }
                ?>
            </table>
            </div> 
        </div>
    </div> 
    <!-- ------->
@endsection
@section ('script') 
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