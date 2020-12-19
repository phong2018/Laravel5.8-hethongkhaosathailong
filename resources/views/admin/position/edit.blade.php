@extends ('admin.layouts.index')

@section ('title')
<title>Sửa Vị Trí</title>
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
  
                     <form  action="{{url('admin/position', [$position->ID_Pos])}}"   accept-charset="UTF-8" method="POST" enctype="multipart/form-data">    

                

                         {{ method_field('PUT') }}{{csrf_field()}}
                        <div class="form-group row">
                            <label for="pos_name" class="col-md-2 col-form-label text-md-right">{{ __('Tên Chức Vụ') }}</label>

                            <div class="col-md-10">
                                <input id="pos_name" type="text" class="form-control{{ $errors->has('pos_name') ? ' is-invalid' : '' }}" name="pos_name"  value="{{$position->pos_name}}" required>

                                @if ($errors->has('pos_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pos_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pos_short" class="col-md-2 col-form-label text-md-right">{{ __('Viết Tắt') }}</label>

                            <div class="col-md-10">
                                <input id="pos_short" type="text" class="form-control{{ $errors->has('pos_short') ? ' is-invalid' : '' }}" name="pos_short"  value="{{$position->pos_short}}"  required>

                                @if ($errors->has('pos_short'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pos_short') }}</strong>
                                </span>
                                @endif
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
@endsection

@section ('script')