@extends ('admin.layouts.index')

@section ('title')
<title>danh sách các lĩnh vực Đơn vị quản lý</title>
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
        <a href="{{ route('role.create')}} " class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Thêm Mới
		</a>
    </div>
  </div>

	<div class="col-md-12 col-lg-12 col-xs-12">
	 
	 
		 


		<table class="table panel panel-default">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Tên Quyền</th>
					<th scope="col">Trạng Thái</th>
					<!-- <th scope="col">Status</th>
					<th scope="col">Recived Date</th>
					<th scope="col">Return Date</th> -->
					<th scope="col" class='width1pt'>Hành động </th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach ($roles as $role)
				<tr>
					<td>{{ $i }}</td>
					<td>{{$role->role_name}}</td>
					<td><?php
					if ($role->role_active == '1') { ?>
						 
						<img style="cursor:pointer;" id="change" onclick="changeActive({{$role->ID_Role}})" src="{{url('/')}}/public/dakichhoat.png"/>

					<?php }else{ ?>
					 

						<img style="cursor:pointer;"   id="change" onclick="changeActive({{$role->ID_Role}})" src="{{url('/')}}/public/chuakichhoat.png"/>


					<?php } ?>
				</td>


				<td>
		 				
		 				<table class='iconaction'><td>
					<a data-original-title="Sửa Chức Vụ" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/role/' . $role->ID_Role . '/edit')}}"><i class="fas fa-edit"></i></a></td><td>&nbsp&nbsp </td><td>
					<span data-original-title="Xóa Chức vụ" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$role->ID_Role}})" ><i class="fa fa-trash-o " ></i></span></td></table>



					 


				</td>
			</tr>
			<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	{{ $roles->render() }}
</div>
</div>
</div>
@endsection

@section ('script')
<script>
/*$(document).ready(function() {
    $('#example').DataTable();
});*/
function delObj(tl){
	var r =confirm('Bạn có chắc chắn xóa quyền này không ?');
	if(r){
		window.location="role/delete/"+tl;
	}
}

function changeActive(id){
    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});

    if (!confirm("Bạn có chắc tắt trạng thái của lĩnh vực này?")) {
        //.......
    } else {
     
    $.ajax({
        url: "role/changeactive/"+id,
        type: 'GET', 
        dataType: "JSON",
        data: {
            "id": id
        },
        success: function (response)
        {
            //alert('YES');
            window.location.href = "{{ URL::to('admin/role') }}";
        },
        error: function(xhr) {
            // alert('NO');
            console.log(xhr.responseText);  
       }
    });
    }
}
</script>
@endsection