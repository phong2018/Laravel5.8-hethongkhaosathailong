@extends ('admin.layouts.index')

@section ('title')
<title>Thêm Vị Trí Mới</title>
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
        <a href="{{ route('position.create')}} " class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Thêm Mới
		</a>
    </div>
  </div>
	<div class="col-md-12 col-lg-12 col-xs-12">
 
		 
		  
		 


		<table class="table panel panel-default">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Tên</th>
					<th scope="col"  class='plghidden'>Trạng Thái</th>
					<th scope="col">Viết Tắt</th>
					<!-- <th scope="col">Status</th>
					<th scope="col">Recived Date</th>
					<th scope="col">Return Date</th> -->
					<th scope="col" class=' width1pt' >Hành động</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach ($position as $pos)
				<tr>
					<td>{{ $i }}</td>
					<td>{{$pos->pos_name}}</td>
					<td  class='plghidden'><?php
						if ($pos->pos_note == '1') { ?>
							 
							<img style="cursor:pointer;" id="change" onclick="changeActive({{$pos->ID_Pos}})" src="{{url('/')}}/public/dakichhoat.png"/>

						<?php }else{ ?>
							 

							<img style="cursor:pointer;"   id="change"  onclick="changeActive({{$pos->ID_Pos}})" src="{{url('/')}}/public/chuakichhoat.png"/>


						<?php } ?>
					</td>
					<td>{{$pos->pos_short}}</td>
					<td>

						<table class='iconaction'><td>
					<a data-original-title="Sửa Chức Vụ" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/position/' . $pos->ID_Pos . '/edit')}}"><i class="fas fa-edit"></i></a></td><td>&nbsp&nbsp </td><td>
					<span data-original-title="Xóa Chức vụ" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$pos->ID_Pos}})" ><i class="fa fa-trash-o " ></i></span></td></table>

 

					</td>
			</tr>
			<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	{{ $position->render() }}
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
	var r =confirm('Bạn có chắc chắn xóa chức vụ này không ?');
	if(r){
		window.location="position/delete/"+tl;
	}
}

function changeActive(id){
	var r = confirm('Bạn chắc chắn đổi trạng thái của chức vụ này?');
        if (r) {
            $.ajax({
                url: 'position/change',
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