@extends ('admin.layouts.index')

@section ('title')
<title>Danh sách thiết bị</title>
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
	<div class="col-md-12 col-lg-12 col-xs-12">
		 
 		<form method="GET" action="" enctype="multipart/form-data" style="padding-bottom: 10px;">      

           <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-org_id">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Đơn vị.">Chọn Đơn vị</span>
                </label>
                
                <select id="org_id"    name="filter_device_orgid" class="form-control{{ $errors->has('org_id') ? ' is-invalid' : '' }}">
                     <option value="0">Choose...</option>
                    @foreach($data['orgs'] as $org)
                    <option 
                    @if ($data['filter_device_orgid']==$org->org_id)
                    selected
                    @endif

                    value="{{$org->org_id}}">{{$org->org_name}}</option>
                    @endforeach 
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-isActived">
                  <span data-toggle="tooltip" data-container="" title="" data-original-title="Tình trạng.">Tình trạng</span>
                </label>
                
                <select id="device_isActived"  name="filter_device_isActived"  class="form-control"  required>
                      <option value="">Choose...</option> 
                      <?php 
                      $tengoi=array();
                      $tengoi[0]='Chưa kích hoạt';    
                      $tengoi[1]='Kích hoạt';    
                      for ($x = 0; $x<2; $x++) { ?>
                          <option  value="{{$x}}"
                          @if ($data['filter_device_isActived']==$x)
                              selected
                              @endif
                          > {{$tengoi[$x]}}
                          </option>
                      <?php }?>
                      
                  </select>
              </div>
            </div>
            <div class="col-sm-4 text-right">
				<div class="form-group">
					 
					<table class='pull-right bordernone '>
						 
						<tr><td style="padding-top:20px;padding-left: 10px;"> 
						<button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i>  Tìm kiếm</button> 
						</td> 
            <td style="padding-top:20px;">
              <?php if($data['uslv1']==1){ ?>
              <a href="{{ route('device.create')}} " class="pull-right btn btn-primary">
              <span class="glyphicon glyphicon-plus-sign"></span> Thêm Mới
              </a>
              <?php } ?>

            </td>
          </tr>
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
			<th scope="col">Tên thiết bị</th>
			<th scope="col">Mã thiết bị</th>
			<th scope="col">Ngày đăng ký</th>
			<th scope="col">Đơn vị</th>
			<th scope="col">Trạng Thái</th>
			<th scope="col" class='width1pt'>Hành động </th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		@foreach ($devices as $device)
		<tr>
			<td>{{ $i }}</td>
			<td>{{$device->device_name}}</td> 
			<td>{{$device->device_uid}}</td>
			 
			<td>{{date('d-m-Y', strtotime($device->device_registerDate))}}</td>
			<td>
				<?php
				if(isset($device->Org->org_name))echo $device->Org->org_name;
				?>
			</td>
			<td><?php
				if ($device->device_isActived == 1) { ?>
					 <img src="{{url('/')}}/public/dakichhoat.png"/>
				<?php }else{ ?>
					 <img src="{{url('/')}}/public/chuakichhoat.png"/>
				<?php } ?>
			</td>
			<td>

				<table class='iconaction'><td>
					<a data-original-title="Sửa Thông Lịch làm việc" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/device/' . $device->device_id. '/edit')}}"><i class="fas fa-edit"></i></a></td><td> &nbsp &nbsp </td>
          <?php if($data['uslv1']==1){ ?>
          <td><span data-original-title="Xóa lịch làm việc" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$device->device_id}})" ><i class="fa fa-trash-o " ></i></span></td>
          <?php } ?>
        </table>




 
			</td>
		</tr>
		<?php $i++; ?>
		@endforeach
	</tbody>
</table>
{{ $devices->render() }}
	</div>
</div>
</div>
@endsection

@section ('script')
<script>
 function delObj(id){
	var r = confirm('Bạn chắc chắn xóa thiết bị này?');
        if (r) {
        	//alert(id);
        	$.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                url: 'device/'+id,
                type: "DELETE",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);
                	alert("Xóa thiết bị thành công ");
                	window.location="device";
                },
                error:function () {//alert("NO");
                		//alert(0);
                    console.log("i cant's run. Please check bug!");
                }
            });
        }
}

 
 

</script>
@endsection