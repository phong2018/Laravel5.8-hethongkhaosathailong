@extends ('admin.layouts.index')



@section ('title')
<title>Danh sách Backup</title>
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
<div class="row">
 

	<div class="col-md-12 col-lg-12 col-xs-12">
		

	 
	 <h1>Danh sách Backup</h1>
	 	<table class='borderchinone pull-right'><td>
		<a data-toggle="tooltip" data-original-title="Tạo File Backup từ Cơ sở Dữ liệu" href="backup/create" class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-plus-sign"></span> Tạo Backup
		</a>
		</td> <td>
		<a data-toggle="tooltip" data-original-title="Tải file Backup từ máy tính lên" href="backup/backupupload" class="pull-right btn btn-primary">
		<span class="glyphicon glyphicon-upload"></span> Upload Backup
		</a></td></table>




	<table class="table panel panel-default">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Tên</th>
			<th scope="col">Ngày tạo</th>
			<th scope="col" class='width1pt'>Hành động </th>

		</tr>
	</thead>
	<tbody>
		@foreach ($bk as $no=>$bki)
		<tr>
			<td>{{$data['startpage']+$no}} </td>
			<td>{{$bki->title}}</td>
		 
			<td>
        {{date('d-m-Y', strtotime($bki->created_at))}}
      </td>
			
			
			<td>


				<table class='iconaction'>
					<td>
					<span data-original-title="Tải file Backup" data-toggle="tooltip" class=' btn btn-warning' onclick="downObj({{$bki->id}})" ><span class="glyphicon glyphicon-download-alt"></span></span></td><td>&nbsp&nbsp </td>
					<td>
					<a data-original-title="Phục hồi Dữ liệu" data-toggle="tooltip" class=' btn btn-success' href="backup/restore/{{$bki->id}}"> <span class="glyphicon glyphicon-refresh"></a></td><td>&nbsp&nbsp </td><td>
					<span data-original-title="Xóa file Backup" data-toggle="tooltip" class=' btn btn-danger' onclick="delObj({{$bki->id}})" ><i class="fa fa-trash-o " ></i></span></td>

					

				</table> 

				 



			</td>
		</tr>
		 
		@endforeach
    </tbody>
	</table>

	 
    {{ $bk->render() }}
	</div>
</div>
</div>
@endsection

@section ('script')
<script>
 
function delObj(tl){
	var r =confirm('Bạn có chắc chắn xóa backup này không ?');
	if(r){
		window.location="backup/delete/"+tl;
	}
} 
function downObj(tl){
	var r =confirm('Bạn có chắc chắn tải backup này không ?');
	if(r){
		window.location="backup/download/"+tl;
	}
} 
</script>
@endsection