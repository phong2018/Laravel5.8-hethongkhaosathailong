@extends ('admin.layouts.index')

@section ('title')
<title>danh sách mẫu</title>
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
        <a href="{{ route('temp.create')}} " class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Thêm Mới
		</a>
    </div>
  </div>

	<div class="col-md-12 col-lg-12 col-xs-12">
	 
		 


		<table class="table panel panel-default">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Tên mẫu</th>
					<th scope="col">Ghi Chú</th>
		 
					<th scope="col">Đường dẫn</th> 
					<th scope="col">Thứ tự</th> 
					<th scope="col" style='width:1%'>Hành động</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach ($temps as $temp)
				<tr>
					<td>{{ $i }}</td>
					<td>{{$temp->temp_name}}</td>
					
					<td> {{$temp->temp_note}} </td>
					<td> {{$temp->temp_path}} </td>
					<td> {{$temp->temp_order}} </td>

				<td>

					<table class='iconaction'><td>
					<a data-original-title="Sửa Mẫu" data-toggle="tooltip" class=' btn btn-success' href="temp/{{$temp->id_template}}/edit"><i class="fas fa-edit"></i></a></td><td>&nbsp&nbsp </td><td>
					<span data-original-title="Xóa Mẫu" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$temp->id_template}})" ><i class="fa fa-trash-o " ></i></span></td></table>



				</td>
			</tr>
			<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	{{ $temps->render() }}
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
	var r =confirm('Bạn có chắc chắn xóa hồ sơ này không ?');
	if(r){
		window.location="temp/delete/"+tl;
	}
}
function changeActive(id){
	var r = confirm('Bạn có chắc ẩn quy trình của lĩnh vực này?');
        if (r) {
            $.ajax({
                url: 'temps/change',
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