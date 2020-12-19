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
		<a href="assign/add" class="btn btn-primary">Thêm Nhiệm Vụ</a>

		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Nhân Viên</th>
					<th scope="col">Lĩnh Vực Quản Lý</th>
					<th scope="col">Trạng Thái</th>

			<!-- <th scope="col">Status</th>
			<th scope="col">Recived Date</th>
			<th scope="col">Return Date</th> -->
			<th scope="col">Hành Động</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		@foreach ($assigns as $assign)
		<tr>
			<td>{{$i}}</td>
			<td>{{$assign->employeess->fullname }}</td>
			<td>{{$assign->proceduress->procedure_name }}</td>
			<td><?php
				if ($assign->active == '1') { ?>
					<i class='far fa-check-square btn_delObj' id="change" onclick="changeActive({{$assign->ID_Assign}})"> Kích hoạt</i>
				<?php }else{ ?>
					<i class="fa fa-trash-o btn_delObj" id="change" onclick="changeActive({{$assign->ID_Assign}})"> Chưa kích hoạt</i>
				<?php } ?>
			</td>
			<td>
				<a href="assign/edit/{{$assign->ID_Assign}}"><i class="fas fa-edit"></i></a>
				<i class="fa fa-trash-o btn_delObj" onclick="delObj({{$assign->ID_Assign}})"></i>
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
	var r =confirm('Bạn có chắc chắn xóa nhiệm này không ?');
	if(r){
		window.location="assign/del/"+tl;
	}
}
function changeActive(id){
	var r = confirm('Bạn chắc chắn thay đổi trạng thái của nhiệm vụ này?');
	if (r) {
		$.ajax({
			url: 'assign/change',
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