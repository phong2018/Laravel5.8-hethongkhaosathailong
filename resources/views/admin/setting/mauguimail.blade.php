@extends ('admin.layouts.index')

@section ('title')
<title>Thiết Lập Chung</title>
@endsection
@section ('style')

@section ('content')
<?php 
//echo nl2br(htmlspecialchars($data['content']));
?>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-pencil"></i> Chỉnh Mẫu Gửi Email</h3>
</div>
 <div class="row justify-content-center ">
  <div class="container-fluid">

<form action="{{url('admin/setting/capnhatmauguimail')}}" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
     {{csrf_field()}}
 <div class="form-group">
<textarea id="my-editor" name="content" class="form-control">
<?php echo $data['content']; ?>
</textarea>
</div>
<div  style="" class=' '>
      <button type="submit" class="btn btn-primary">
          LƯU MẪU
      </button>
 </div>
</form>

</div></div></div>
<script src="<?php echo e(asset('/public/ckeditor/ckeditor.js')); ?>"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
</script>
<script>
CKEDITOR.replace('my-editor', options);
</script>

   
@endsection

@section ('script')


 


