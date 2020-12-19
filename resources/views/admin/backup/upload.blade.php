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
 <h1>Upload file Backup</h1>
 <form method="POST"  id='formDor' action="{{url('admin/backup/storebackupupload')}}"  enctype="multipart/form-data">
        @csrf
        <div class="form-group row mb-0 ">
            <div class="col-md-12">
                <h3>Chọn file Backup</h3>
                <input   type="file" class=" " name="fileuploadbackup"  >
                <p>(Chọn File .sql)</p>
            </div>
            <div class="col-md-12 offset-md-12">
                <button type="submit" class="btn btn-primary ">
                    {{ __('Lưu Lại') }}
                </button>
                &nbsp 
                <a onclick="document.getElementById('nutquaylai').click();" type="submit" class="btn btn-primary">
                                Quay Lại
                </a>
            </div>
        </div>
   </form>
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