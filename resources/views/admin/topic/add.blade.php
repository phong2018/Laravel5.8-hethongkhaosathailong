    @extends ('admin.layouts.index')

    @section ('title')
    <title>Thêm Chủ đề Mới</title>
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
                    <div class="card-body">
      
                        <form  action="{{ route('topic.store')}}" accept-charset="UTF-8" method="POST" enctype="multipart/form-data">    
                            @csrf

                            <div class="form-group row">
                                <label for="topic_name" class="col-md-2 col-form-label text-md-right">{{ __('Tên Chủ đề') }}</label>

                                <div class="col-md-10">
                                    <input id="topic_name" type="text" class="form-control{{ $errors->has('topic_name') ? ' is-invalid' : '' }}" name="topic_name" required>

                                    @if ($errors->has('topic_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('topic_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Mô tả">Mô tả </span></label>
                                <div class="col-md-10">
                                    <textarea  id="topic_description" name="topic_description" class="form-control"> </textarea>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="topic_type" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Loại chủ đề: 1- Khảo sát đơn vị; 2- Khảo sát cá nhân">Loại chủ đề <i class="fa fa-question-circle"></i></span></label>

                                <div class="col-md-10">
                                    <select id="topic_type"  name="topic_type"  class="form-control"  required>
                                        <option value="">Choose...</option> 
                                        <?php 
                                        $tengoi=array();
                                        $tengoi[2]='Loại 2 - Khảo sát nhân viên';    
                                        $tengoi[1]='Loại 1 - Khảo sát đơn vị';    
                                        for ($x = 1; $x<3; $x++) { ?>
                                            <option  value="{{$x}}"> {{$tengoi[$x]}}
                                            </option>
                                        <?php }?>
                                        
                                    </select>
                                </div>
                            </div> 

                          <div class="form-group plghidden">
                            <label class="col-sm-2 control-label" for="input-logo">Hình đại diện</label>
                            <div class="col-sm-10">
                                <?php $thumb="/thumb.png";?>
                                <div class="input-group">
                                  <input type="button" id="lfm" data-input="topic_thumb" data-preview="holder" value="Upload">
                                  <input type="hidden" id="topic_thumb" class="form-control" value="{{$thumb}}" type="text" name="topic_thumb">
                              </div>
                              
                                <img id="holder" src="{{url('/')}}/public{{$thumb}}" style="margin-top:15px;max-height:100px;">
                              
                              <script src="{{url('/')}}/public/vendor/laravel-filemanager/js/lfm.js"></script>
                              <script>
                                  var options = {prefix:"{{url('/public/')}}"}
                                  $('#lfm').filemanager('image',options);
                              </script> 
                              


                            </div>
                          </div>
                            

                             <div class="form-group row">
                                <label for="topic_isActived" class="col-md-2 col-form-label text-right">{{ __('Trạng Thái') }}</label>
                                <div class="col-md-10">
                                    <table class='borderchinone'><td>
                                    <label for="active" class="col-form-label text-md-righ">{{ __('Bật') }} &nbsp</label>
                                    </td><td>
                                    <input id="active" type="radio"  name="topic_isActived" checked="checked" value="1">
                                    </td> <td style="width:20px;">
                                    </td><td>
                                    <label for="inactive" class="col-form-label text-md-righ">{{ __('Tắt') }}  &nbsp</label>
                                    </td><td>
                                    <input id="inactive" type="radio"  name="topic_isActived" value="0"> 
                                     </td></table>

                                </div>
                            </div>
                             

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
  //----------
  var options = {
    filebrowserImageBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
     height : '150px'
  };
  CKEDITOR.replace('topic_description', options);
  
    </script>

    @endsection

    @section ('script')