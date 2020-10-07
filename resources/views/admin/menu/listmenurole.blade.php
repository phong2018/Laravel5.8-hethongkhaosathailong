@extends ('admin.layouts.index')

@section ('title')
<title>danh sách các menu được quản lý tại website</title>
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
<div class="row">
	<div class="col-md-12 col-lg-12 col-xs-12">
		<a href="menurole/add" class="btn btn-primary">Tạo Phân Quyền Mới Cho Menu</a>

		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Quyền</th>
					<th scope="col">Menu Có Thể Quản Lý</th>
					<th scope="col">Trạng Thái</th>

			<!-- <th scope="col">Status</th>
			<th scope="col">Recived Date</th>
			<th scope="col">Return Date</th> -->
			<th scope="col">Hành Động</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		@foreach ($menurole as $r)
		<tr>
			<td>{{$i}}</td>
			<td>{{$r->roless->role_name}}</td>
			<td>{{$r->menuss->menu_name}}</td>
			<td><?php
				if ($r->menurole_actived == '1') { ?>
					<img style="cursor:pointer;" id="change" onclick="changeActive({{$r->ID_Menurole}})" src="{{url('/')}}/public/dakichhoat.png"/>

					 
				<?php }else{ ?>
					 
					<img style="cursor:pointer;"   id="change" onclick="changeActive({{$r->ID_Menurole}})" src="{{url('/')}}/public/chuakichhoat.png"/>

				<?php } ?>
			</td>
			<td>
				<a href="sector/edit/"><i class="fas fa-edit"></i></a>
				<i class="fa fa-trash-o btn_delObj" onclick="delObj({{$r->ID_Menurole}})"></i>
			</td>
		</tr>
	<?php $i++; ?>
	@endforeach
</tbody>
</table>

</div>
</div>
@endsection

@section ('script')
<script>
/*$(document).ready(function() {
    $('#example').DataTable();
});*/
function delObj(tl){
	var r =confirm('Bạn có chắc chắn xóa menu này không ?');
	if(r){
		window.location="menu/del/"+tl;
	}
}
function changeActive(id){
	var r = confirm('Bạn chắc chắn thay đổi trạng thái của menu này?');
	if (r) {
		$.ajax({
			url: 'menu/change',
			type: "POST",
			data: {'active' : id},
			beforeSend: function (xhr) {
				var token = $('meta[name="csrf-token"]').attr('content');
				if (token) {
					return xhr.setRequestHeader('X-CSRF-TOKEN', token);
				}                
			},
			success:function (data) {
				$("#change").html(data);
			},
			error:function () {
				console.log("i cant's run. Please check bug!");
			}
		});
	}
}
</script>
@endsection