@extends ('admin.layouts.index')

@section ('title')
<title>Tìm Kiếm thông tin qua từ khóa </title>

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
		<a href="sector/add" class="btn btn-primary">Tạo Lĩnh Vực</a>

		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Tên Lĩnh Vực</th>
					<th scope="col">Trạng Thái</th>
					<!-- <th scope="col">Status</th>
					<th scope="col">Recived Date</th>
					<th scope="col">Return Date</th> -->
					<th scope="col">Hành động </th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach ($sector as $sec)
				<tr>
					<td>{{ $i }}</td>
					<td>{{$sec->sector_name}}</td>
					<td><?php
					if ($sec->sector_active == '1') { ?>
						<i class='far fa-check-square btn_delObj' id="change" onclick="changeActive({{$sec->ID_Sector}})">  Kích hoạt</i>
					<?php }else{ ?>
						<i class="fa fa-trash-o btn_delObj" id="change" onclick="changeActive({{$sec->ID_Sector}})">  Chưa kích hoạt</i>
					<?php } ?>
				</td>


				<td>
					<a href="sector/edit/{{$sec->ID_Sector}}"><i class="fas fa-edit"></i></a>
					<i class="fa fa-trash-o btn_delObj" onclick="delObj({{$sec->ID_Sector}})"></i>
				</td>
			</tr>
			<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	{{ $sector->render() }}
</div>
</div>
@endsection

@section ('script')
<script>
/*$(document).ready(function() {
    $('#example').DataTable();
});*/
function delObj(tl){
	var r =confirm('Bạn có chắc chắn xóa lĩnh vực này không ?');
	if(r){
		window.location="sector/del/"+tl;
	}
}
function changeActive(id){
	var r = confirm('Bạn có chắc ẩn trạng thái của lĩnh vực này?');
        if (r) {
            $.ajax({
                url: 'sector/change',
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