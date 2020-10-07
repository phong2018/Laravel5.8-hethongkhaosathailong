@extends ('admin.layouts.index')

@section ('title')
<title>Thêm mẫu mới</title>
@endsection
@section ('style')

@section ('content')
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

        <div class="col-md-12 col-xs-12 col-lg-12">
            <div class="card">
                
                @if(count($errors) > 0)
                @foreach($errors->all() as $err)
                <div class="alert alert-danger">{{$err}}</div>
                @endforeach
                @endif
                @if(session('messenger'))
                <div class="alert alert-primary">{{session('messenger')}}</div>
                @endif
                <div class="card-body">
                    <form  action="{{url('admin/temp', [$temp->id_template])}}"    accept-charset="UTF-8" method="POST" enctype="multipart/form-data">   
                    {{ method_field('PUT') }}{{csrf_field()}} 

                        <div class="form-group row">
                            <label for="temp_name" class="col-md-2 col-form-label text-md-right">{{ __('Tên Mẫu') }}</label>

                            <div class="col-md-10">
                                <input id="temp_name" type="text" class="form-control{{ $errors->has('temp_name') ? ' is-invalid' : '' }}" name="temp_name" value="{{$temp->temp_name}}"  required>

                                @if ($errors->has('temp_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('temp_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="temp_note" class="col-md-2 col-form-label text-md-right">{{ __('Ghi Chú') }}</label>

                            <div class="col-md-10">
                                <input id="temp_note" type="text" class="form-control{{ $errors->has('temp_note') ? ' is-invalid' : '' }}" value="{{$temp->temp_note}}"  name="temp_note">

                                @if ($errors->has('temp_note'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('temp_note') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="temp_order" class="col-md-2 col-form-label text-md-right">{{ __('Thứ tự') }}</label>

                            <div class="col-md-10">
                                <input id="temp_order" type="text" class="form-control{{ $errors->has('temp_order') ? ' is-invalid' : '' }}" value="{{$temp->temp_order}}"  name="temp_order">

                                @if ($errors->has('temp_order'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('temp_order') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="temp_parameter" class="col-md-2 col-form-label text-md-right">{{ __('Các biến có thể sử dụng') }}</label>
                            <div class="col-md-10">
                               
                                <textarea id="temp_parameter" type="text" class="form-control{{ $errors->has('temp_parameter') ? ' is-invalid' : '' }}"  name="temp_parameter">{{$temp->temp_parameter}}</textarea>


                                @if ($errors->has('temp_parameter'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('temp_parameter') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <textarea id="my-editor" name="content" class="form-control">
                        <?php echo $data['content']; ?>
                        </textarea>
 

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
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
        </div>
    </div>
<script src="<?php echo e(asset('/public/ckeditor/ckeditor.js')); ?>"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Files&_token='
  };
</script>
<script>
CKEDITOR.replace('my-editor', options);
</script>

@endsection

@section ('script')