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
<div class="row justify-content-center">      
    <div class="page-header">
    <div class="container-fluid">
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

  		  <div class="container-fluid1 ">
			<form method="GET" action="" enctype="multipart/form-data" style="padding-bottom: 10px;">    
			


         

            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-org_id">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Đơn vị.">Chọn Đơn vị</span>
                </label>
                
                <select id="org_id" style="color: red;
    font-weight: bold;"    name="filter_orgidlv1" class="form-control{{ $errors->has('org_id') ? ' is-invalid' : '' }}">
                     <option value="0">Choose...</option>
                    @foreach($data['orgs'] as $org)
                    <option 
                    @if ($data['filter_orgidlv1']==$org->org_id)
                    selected
                    @endif

                    value="{{$org->org_id}}">{{$org->org_name}}</option>
                    @endforeach 
                </select>
              </div>
            </div>

             <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-org_id">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Đơn vị.">Sự hài lòng</span>
                </label>
                
                <select id="suhailong"    name="filter_suhailong" class="form-control">
                     <option value="0"
                     <?php if($data['filter_suhailong']==0) echo "selected"; ?>
                     >Choose...</option>
                     <option value="1"
                     <?php if($data['filter_suhailong']==1) echo "selected"; ?>
                     >Hài lòng</option>
                     <option value="2"
                     <?php if($data['filter_suhailong']==2) echo "selected"; ?>
                     >Bình thường</option>
                     <option value="3"
                     <?php if($data['filter_suhailong']==3) echo "selected"; ?>
                     >Chưa hài lòng</option>

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
						<button type="submit" name="xoadulieu" class="btn btn-primary"  onClick="return checkform();"> <i class="fa fa-trash-o "></i> Xóa Dữ Liệu</button> 
						</td></tr>
					</table>
					<br><br> 
				</div>
			</div>

          </form>
            </div>
    <div class="col-md-12 col-lg-12 col-xs-12">
  <div class="container">
  <div  class="panel panel-default" style="padding:15px;">
  <table class='table'>
  <th class=' width1pt'>#</th><th>Chủ đề</th><th>Đối tượng</th><th>Khách hàng</th><th>Thời gian</th><th class=' width1pt'>Hành động</th>
   <?php
        //print_r($survey);
      foreach($survey as $no=>$val){
        echo "<tr>";
        echo '<td>'.($no+1).'</td>';
        echo '<td>'.$val->Topic->topic_name.'</td>';
        if($val->Topic->topic_type==1)//don vi
        echo '<td>'.$val->Object_org->org_name.'</td>';
        else
        echo '<td>'.$val->Object_us->fullname.'</td>';

        echo '<td>'.$val->survey_customer.'</td>';

        echo '<td>'.date('d-m-Y', strtotime($val->survey_created_at)).'</td>';

        echo '<td>';
        ?>
        <table class='iconaction'><td>
          <a data-original-title="Xem bài khảo sat" data-toggle="tooltip" class=' btn btn-success' href="show/{{$val->survey_id}}"><span style="color:blue;" class="glyphicon glyphicon-eye-open"></span></a></td><td>&nbsp&nbsp </td><td>
          <span data-original-title="Xóa bài khảo sát" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$val->survey_id}})" ><i class="fa fa-trash-o " ></i></span></td></table>

        <?php
        echo '</td>';
        echo '</tr>';
      }
   ?>
 </table>
		 
 </div> 

 <?php echo $survey->appends($data['addurl'])->render();
//$survey->render()
  ?>

	</div>
  </div>

</div>
</div>
@endsection

@section ('script')
<script> 

  function checkform(){
     var r = confirm("Bạn muốn xóa dữ liệu khảo sát?");
    if (r == true) {
      return true;
    } else {
      return false;
    }
  }

  function delObj(tl){
  var r =confirm('Bạn có chắc chắn xóa bài khảo sát này không ?');
  if(r){
    window.location="{{ url('admin/survey/delete') }}/"+tl;
  }
} 
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
  height:20px;
  color: black;
}

.skillsbar {
  text-align: right;
  padding-top: 0px;
  padding-bottom: 0px;
  color: black;
  background:red;
  height:20px;
}
.widthkq{
  width:200px;
}
</style>
@endsection 