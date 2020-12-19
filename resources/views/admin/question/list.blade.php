@extends ('admin.layouts.index')

@section ('title')
<title>Thêm Câu hỏi</title>
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
        <a href="{{ route('question.create')}} " class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Thêm Mới
		</a>
    </div>
  </div>
	<div class="col-md-12 col-lg-12 col-xs-12">
 
		<table class="table panel panel-default">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Mô tả Câu hỏi</th>
					<th scope="col"  >Điểm số</th> 
					<th scope="col"  >Chủ đề</th>
					<th scope="col">Tình trạng</th>
					<th scope="col" class=' width1pt' >Hành động</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				@foreach ($question as $val)
				<tr>
					<td>{{ $i }}</td>
					<td><?php echo $val->question_description;?></td> 
					<td>{{$val->question_scores}}</td>   
					<td><?php
					if(isset($val->Topic->topic_name))
					echo $val->Topic->topic_name;

					?></td>  
					 
					<td><?php
					if($val->question_isActived==0) echo "Tắt";else echo "Bật";
					?></td>
					<td>
 					<table class='iconaction'>
 						<td>
					<a data-original-title="Sao chép câu hỏi" data-toggle="tooltip" class=' btn btn-warning' href="{{ URL::to('admin/question/' . $val->question_id. '/copy')}}"><i class="fa fa-plus-square-o"></i></a></td><td> &nbsp &nbsp </td>
					<td>
					<a data-original-title="Sửa Câu hỏi" data-toggle="tooltip" class=' btn btn-success' href="{{ URL::to('admin/question/' . $val->question_id. '/edit')}}"><i class="fas fa-edit"></i></a></td>
					<td> &nbsp &nbsp </td><td>
					<span data-original-title="Xóa Câu hỏi" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$val->question_id}})" ><i class="fa fa-trash-o " ></i></span></td>
					</table>
					</td>
			</tr>
			<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	{{ $question->render() }}
</div>
</div>
</div>
@endsection

@section ('script')
<script>
function delObj(id){
	var r = confirm('Bạn chắc chắn xóa Câu hỏi này?');
        if (r) {
        	$.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                url: 'question/'+id,
                type: "DELETE",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);
                	alert("Xóa Câu hỏi thành công ");
                	window.location="question";
                },
                error:function () {//alert("NO");
                    console.log("i cant's run. Please check bug!");
                }
            });
        }
}
</script>
@endsection