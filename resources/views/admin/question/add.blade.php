    @extends ('admin.layouts.index')

    @section ('title')
    <title>Thêm Câu hỏi Mới</title>
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
      
                        <form  action="{{ route('question.store')}}" accept-charset="UTF-8" method="POST" enctype="multipart/form-data">    
                            @csrf

                            <div class="form-group row">

                            <label for="question_idTopic" class="col-md-2 col-form-label text-md-right">{{ __('Chủ đề') }}</label>

                            <div class="col-md-10">
                                <select id="question_idTopic" name="question_idTopic" class="form-control{{ $errors->has('question_idTopic') ? ' is-invalid' : '' }}"  required >
                                    @if(count($topic)>1)
                                    <option value="">Choose...</option>
                                    @endif
                                    @foreach($topic as $val)
                                    <option value="{{$val->topic_id}}">{{$val->topic_name}}</option>
                                    @endforeach
                                </select>
                                 @if ($errors->has('question_idTopic')) 
                                    <p class='plgalert'>{{ $errors->first('question_idTopic') }}</p>
                                  @endif
                            </div>

                          </div>


                            <div class="form-group row">
                                <label for="role" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Mô tả">Mô tả câu hỏi</span></label>
                                <div class="col-md-10">
                                    <textarea  id="question_description" name="question_description" class="form-control"> </textarea>
                                </div>
                            </div> 

                            
                    

                         
                             <div class="form-group row">
                                <label for="question_order" class="col-md-2 col-form-label text-md-right">{{ __('Thứ tự câu hỏi') }}</label>

                                <div class="col-md-10">
                                    <input id="question_order" type="number" class="form-control{{ $errors->has('question_order') ? ' is-invalid' : '' }}" name="question_order" required>

                                    @if ($errors->has('question_order'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('question_order') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="question_scores" class="col-md-2 col-form-label text-md-right">{{ __('Điểm đánh giá') }}</label>

                                <div class="col-md-10">
                                    <input id="question_scores" type="number" class="form-control{{ $errors->has('question_scores') ? ' is-invalid' : '' }}" name="question_scores" required>

                                    @if ($errors->has('question_scores'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('question_scores') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="question_type" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Loại Câu hỏi: Nhiều lựa chọn, chọn 1 câu trả lời">Loại Câu hỏi <i class="fa fa-question-circle"></i></span></label>

                                <div class="col-md-10">
                                    <select id="question_type"  name="question_type"  class="form-control"  required>
                                        
                                        <?php 
                                        $tengoi=array();
                                        //$tengoi[3]='Loại 3- Nhập văn bản trả lời';
                                        $tengoi[2]='Nhiều lựa chọn, chọn nhiều câu trả lời';    
                                        $tengoi[1]='Nhiều lựa chọn, chọn 1 câu trả lời';    
                                        for ($x = 1; $x<=1; $x++) { ?>
                                            <option  value="{{$x}}"> {{$tengoi[$x]}}
                                            </option>
                                        <?php }?>
                                        
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="question_options" class="col-md-2 col-form-label text-md-right">{{ __('Số tùy chọn trả lời') }}</label>

                                <div class="col-md-10">
                                    <input id="question_options" onchange="capnhattraloi(this.value)" type="number" class="form-control{{ $errors->has('question_options') ? ' is-invalid' : '' }}" name="question_options" required>

                                    @if ($errors->has('question_options'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('question_options') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        


                             <div class="form-group row">
                                <label for="question_isActived" class="col-md-2 col-form-label text-right">{{ __('Trạng Thái') }}</label>
                                <div class="col-md-10">
                                    <table class='borderchinone'><td>
                                    <label for="active" class="col-form-label text-md-righ">{{ __('Bật') }} &nbsp</label>
                                    </td><td>
                                    <input id="active" type="radio"  name="question_isActived" checked="checked" value="1">
                                    </td> <td style="width:20px;">
                                    </td><td>
                                    <label for="inactive" class="col-form-label text-md-righ">{{ __('Tắt') }}  &nbsp</label>
                                    </td><td>
                                    <input id="inactive" type="radio"  name="question_isActived" value="0"> 
                                     </td></table>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cautraloi" class="col-md-2 col-form-label text-right">{{ __('Các câu trả lời') }}</label>
                                <div class="col-md-10" style="padding-top: 0px;">
                                <div id='caccautraloi'>
                                </div></div>
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
    filebrowserImageUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '{{url("/public/")}}/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '{{url("/public/")}}/laravel-filemanager/upload?type=Files&_token=',
    height : '150px',
  };
  CKEDITOR.replace('question_description', options);

function capnhattraloi(option){//alert(option);
    $("#caccautraloi").html(""); 
    for(var i=1;i<=option;i++){
        var idi="traloi"+i;
        var traloi=""; 
        traloi+="<div class='col-md-12'><br> <strong>Câu "+i+": &nbsp </strong><input type='number'  required   name='diem"+idi+"' placeholder='Số điểm'/><br><br><textarea id='"+idi+"' name='"+idi+"'></textarea></div>";
        $("#caccautraloi").append(traloi);

        CKEDITOR.replace(idi, options);
    }
}
  
</script>

    @endsection

    @section ('script')