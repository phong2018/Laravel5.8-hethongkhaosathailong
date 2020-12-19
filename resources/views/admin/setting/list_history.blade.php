@extends ('admin.layouts.index')



@section ('title')

<title>Nhật ký hoạt động</title>

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

  

<div class=' '>

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

    </div>

  </div>

	<div class="col-md-12 col-lg-12 col-xs-12">



		 



	<form method="GET" action="" enctype="multipart/form-data">

		<table style='margin:auto;' class='borderchinone' ><td>

		<div class="form-group">

               

                <input type="text" name="filter_Ma_Hoso" value="{{$data['filter_Ma_Hoso']}}" placeholder="Nhập Mã hồ sơ" id="input-Ma_Hoso" class="form-control" />

              </div></td><td style='width:1%'>

              <button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> Tìm Kiếm</button> </td></table>

        </form>

        <br>



		<table class="table panel panel-default">

			<thead>

				<tr>

					<th scope="col">#</th>

					<th scope="col">Nội dung</th>

					<th scope="col">Ngày tạo</th> 

					<th class='width1pt'>Hành động</th>

				</tr>

			</thead>

			<tbody>

				<?php $i = 1; ?>

				@foreach ($hiss as $his)

				<tr>

					<td>{{ $i }}</td>

					<td><span><?php

							foreach($his['content'] as $no=>$h){

								

								if($no==0){

									echo '<strong> '.$h.'</strong><br>';

								}else{

									if($no<count($his['content'])-1)echo $h.'<br>';

									else echo $h;

								}

							}

						?>

					</td>

					<td> 

						 {{date('d-m-Y', strtotime($his['created_at']))}}

					</td>



					<td>

						<span data-original-title="Tải file Nhật ký" data-toggle="tooltip" class=" btn btn-warning" onclick="downObj({{$his['ID_Dossier']}})"><span class="glyphicon glyphicon-download-alt"></span></span>

 

						</td>

				 

				</td>

			</tr>

			<?php $i++; ?>

			@endforeach

		</tbody>

	</table>

	{{ $dorr->render() }}

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

	var r =confirm('Bạn có chắc chắn xóa nhật ký này không ?');

	if(r){

		window.location="nhatky/delete/"+tl;

	}

} 



function downObj(tl){

	var r =confirm('Bạn có chắc chắn tải backup này không ?');

	if(r){

		window.location="nhatky/download/"+tl;

	}

} 



function changeActive(id){

    $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});



    if (!confirm("Bạn có chắc tắt trạng thái của lĩnh vực này?")) {

        //.......

    } else {

     

    $.ajax({

        url: "sector/changeactive/"+id,

        type: 'GET', 

        dataType: "JSON",

        data: {

            "id": id

        },

        success: function (response)

        {

            //alert('YES');

            window.location.href = "{{ URL::to('admin/sector') }}";

        },

        error: function(xhr) {

            //alert('NO');

            console.log(xhr.responseText);  

       }

    });

    }

}







</script>

@endsection