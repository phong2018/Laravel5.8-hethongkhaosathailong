@extends ('admin.layouts.index')

@section ('title')
<title>danh sách Nhân Viên Đơn vị - Xã</title>
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
		<a href="employee/add" class="btn btn-primary">Thêm Nhân Viên Mới</a>

		<table class="table">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Tên</th>
			<th scope="col">Giới Tính</th>
			<th scope="col">Sđt</th>
			<th scope="col">Zalo</th>
			<th scope="col">Chức Vụ</th>
			<th scope="col">Quyền</th>
			<th scope="col">Trạng Thái</th>
			<th scope="col">Hành động </th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		@foreach ($employee as $user)
		<tr>
			<td>{{ $i }}</td>
			<td>{{$user->fullname}}</td>
			<td>{{$user->sex == 1 ? "Male" : "Female" }}</td>
			<td>{{"0".$user->phone}}</td>
			<td>{{$user->zalo_id}}</td>
			<td>{{$user->Position->pos_name}}</td>
			<td>{{$user->Role->role_name}}</td>
			<td><?php
				if ($user->isActived == '1') { ?>
					<i class='far fa-check-square btn_delObj' id="change" onclick="changeActive({{$user->id}})"> Kích hoạt</i>
				<?php }else{ ?>
					<i class="fa fa-trash-o btn_delObj" id="change" onclick="changeActive({{$user->id}})">  Chưa kích hoạt</i>
				<?php } ?>
			</td>
			<td>
				<a href="employee/edit/{{$user->id}}"><i class="fas fa-edit"></i></a>
			</td>
		</tr>
		<?php $i++; ?>
		@endforeach
	</tbody>
</table>
{{ $employee->render() }}
	</div>
</div>
@endsection

@section ('script')
<script>
/*$(usercument).ready(function() {
    $('#example').DataTable();
});*/

function changeActive(id){
	var r = confirm('Bạn chắc chắn đổi trạng thái của nhân viên này?');
        if (r) {
            $.ajax({
                url: 'employee/change',
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