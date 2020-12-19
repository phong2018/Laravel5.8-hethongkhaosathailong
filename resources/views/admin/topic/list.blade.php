@extends ('admin.layouts.index')

@section ('title')
<title>Thêm Chủ đề</title>
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
        <a href="{{ route('topic.create')}} " class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Thêm Mới
		</a>
    </div>
  </div>

  <div class="container-fluid1 plghidden">
		 <form method="GET" action="" enctype="multipart/form-data">

		<table style='margin:auto;' class='borderchinone' ><td>

		<div class="form-group">

               

                <input type="text" name="filter_ten_chude" value="" placeholder="Tên chủ đề" id="input-ten_chude" class="form-control" />

              </div></td><td style='width:1%'>

              <button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> Tìm Kiếm</button> </td></table>

        </form>
 
     </div>
	<div class="col-md-12 col-lg-12 col-xs-12">
 
		<table class="table panel panel-default">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Tên chủ đề</th>
					<th scope="col"  >Loại chủ đề</th>
					<th scope="col">Tình trạng</th>
					<th scope="col" class=' width1pt' >Hành động</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach ($topic as $val)
				<tr>
					<td>{{ $i }}</td>
					<td>{{$val->topic_name}}</td> 
					<td>
						<?php 
                        $tengoi=array();
                        $tengoi[2]='Loại 2 - Khảo sát nhân viên';    
                        $tengoi[1]='Loại 1 - Khảo sát đơn vị';    
                        for ($x = 1; $x<3; $x++)
                        if($val->topic_type==$x) echo $tengoi[$x];
                   		?>
 					</td>
					<td><?php
					if($val->topic_isActived==0){?>
					<img style="cursor:pointer;"   src="{{url('/')}}/public/chuakichhoat.png"/>	
					<?php } else { ?>
						<img style="cursor:pointer;"   src="{{url('/')}}/public/dakichhoat.png"/>
					<?php }?></td>
					<td>
 					<table class='iconaction'>
					 
					<td>
					<a data-original-title="Sao chép chủ đề" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/topic/' . $val->topic_id. '/copy')}}"><i style='padding-top: 7px;font-size: 16px;' class="fa fa-plus-square-o"></i></a></td>
					<td> &nbsp &nbsp </td>

 						<td>
					<a data-original-title="Sửa Chủ đề & Cập nhật Câu hỏi" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/topic/' . $val->topic_id. '/edit')}}"><i class="fas fa-edit"></i></a></td>
					<td> &nbsp &nbsp </td><td>
					<span data-original-title="Xóa Chủ đề" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$val->topic_id}})" ><i class="fa fa-trash-o " ></i></span></td>
					</table>
					</td>
			</tr>
			<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	{{ $topic->render() }}
</div>
</div>
</div>
@endsection

@section ('script')
<script>
function delObj(id){
	var r = confirm('Bạn chắc chắn xóa Chủ đề này?');
        if (r) {
        	$.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                url: 'topic/'+id,
                type: "DELETE",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);
                	alert("Xóa Chủ đề thành công ");
                	window.location="topic";
                },
                error:function () {//alert("NO");
                    console.log("i cant's run. Please check bug!");
                }
            });
        }
}
</script>
@endsection