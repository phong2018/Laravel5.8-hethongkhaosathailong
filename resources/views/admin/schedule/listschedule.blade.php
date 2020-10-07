@extends ('admin.layouts.index')

@section ('title')
<title>danh sách Lịch Làm Việc</title>
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


 @if($data['checkadmin']==1)
        <a href="{{ route('schedule.create')}} " class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Tạo Mới Lịch Làm Việc
		</a>

 @endif

    </div>
  </div>
	<div class="col-md-12 col-lg-12 col-xs-12">
		 
  <form method="GET" action="" enctype="multipart/form-data" style="padding-bottom: 10px;">      

           <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label" for="input-org_id">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Phường.">Chọn Phường</span>
                </label>
                
                <select id="org_id"    name="filter_schedule_orgid" class="form-control{{ $errors->has('org_id') ? ' is-invalid' : '' }}">
                     <option value="0">Choose...</option>
                    @foreach($data['orgs'] as $org)
                    <option 
                    @if ($data['filter_schedule_orgid']==$org->org_id)
                    selected
                    @endif

                    value="{{$org->org_id}}">{{$org->org_name}}</option>
                    @endforeach 
                </select>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label" for="input-isActived">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="Tình trạng.">Tình trạng</span>
                </label>
                
                <select id="schedule_isActived"  name="filter_schedule_isActived"  class="form-control"  required>
                      <option value="">Choose...</option> 
                      <?php 
                      $tengoi=array();
                      $tengoi[0]='Chưa kích hoạt';    
                      $tengoi[1]='Đã kích hoạt';    
                      for ($x = 1; $x>=0; $x--) { ?>
                          <option  value="{{$x}}"
                          @if ($data['filter_schedule_isActived']==$x)
                              selected
                              @endif
                          > {{$tengoi[$x]}}
                          </option>
                      <?php }?>
                      
                  </select>
              </div>
            </div>
            <div class="col-sm-2 text-right">
				<div class="form-group">
					 
					<table class='pull-right bordernone '>
						 
						<tr><td style="padding-top:20px;"> 
						<button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i>  Tìm kiếm</button> 
						</td> </tr>
					</table>
					<br><br> 
				</div>
			</div>
           
          </form>
          <br>

		<table class="table panel panel-default">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Tên Lịch</th>
			<th scope="col">Morning Start</th>
			<th scope="col">Morning End</th>
			<th scope="col">Afternoon Start</th>
			<th scope="col">Afternoon End</th>
			<th scope="col">Evening Start</th>
			<th scope="col">Evening End</th>
			 
			<th scope="col">Trạng Thái</th>
			<th scope="col">Hành động </th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		@foreach ($schedules as $schedule)
		<tr>
			<td>{{ $i }}</td>
			<td>{{$schedule->schedule_name}}</td>
			 
			<td>{{$schedule->schedule_morningStart}}</td>
			<td>{{$schedule->schedule_morningEnd}}</td>
			<td>{{$schedule->schedule_afternoonStart}}</td>
			<td>{{$schedule->schedule_afternoonEnd}}</td>
			<td>{{$schedule->schedule_eveningStart}}</td>
			<td>{{$schedule->schedule_eveningEnd}}</td>
		 

			<td><?php
				if ($schedule->schedule_isActived == 1) { ?>
					<img src="{{url('/')}}/public/dakichhoat.png"/>
				<?php }else{ ?>
					<img src="{{url('/')}}/public/chuakichhoat.png"/>
				<?php } ?>
			</td>
			<td>

				<table class='iconaction'><td>
					<a data-original-title="Sửa Thông Lịch làm việc" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/schedule/' . $schedule->schedule_id . '/edit')}}"><i class="fas fa-edit"></i></a></td>

          @if($data['checkadmin']==1)


          <td> &nbsp &nbsp </td>
          <td>
          <a data-original-title="Sao chép đơn vị" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/schedule/' . $schedule->schedule_id. '/copy')}}"><i style='padding-top: 7px;font-size: 16px;' class="fa fa-plus-square-o"></i></a></td>

          <td> &nbsp &nbsp </td><td>
					<span data-original-title="Xóa lịch làm việc" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$schedule->schedule_id}})" ><i class="fa fa-trash-o " ></i></span></td>

          @endif

        </table>




 
			</td>
		</tr>
		<?php $i++; ?>
		@endforeach
	</tbody>
</table>
<?php
//{{ $schedules->render() }}
?>
	</div>
</div>
</div>
@endsection

@section ('script')
<script>
 function delObj(id){
	var r = confirm('Bạn chắc chắn xóa lịch làm việc này?');
        if (r) {
        	$.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                url: 'schedule/'+id,
                type: "DELETE",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);
                	alert("Xóa lịch làm việc thành công ");
                	window.location="schedule";
                },
                error:function () {//alert("NO");
                    console.log("i cant's run. Please check bug!");
                }
            });
        }
}

 
 

</script>
@endsection