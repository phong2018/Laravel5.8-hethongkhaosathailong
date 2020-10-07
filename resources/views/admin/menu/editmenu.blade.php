@extends ('admin.layouts.index')

@section ('title')
<title>thêm menu quản lý mới</title>
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
                

                    <form  action="{{url('admin/menu', [$menu->ID_Menu])}}"   accept-charset="UTF-8" method="POST" enctype="multipart/form-data">    

                         {{ method_field('PUT') }}{{csrf_field()}}

                        <div class="form-group row">
                            <label for="menu_name" class="col-md-2 col-form-label text-right">{{ __('Tên Menu') }}</label>

                            <div class="col-md-10">
                                <input id="menu_name" type="text" class="form-control{{ $errors->has('menu_name') ? ' is-invalid' : '' }}" placeholder="Tên Menu"name="menu_name" required value="{{$menu->menu_name}}" >

                                @if ($errors->has('menu_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('menu_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="menu_note" class="col-md-2 col-form-label text-right">{{ __('Ghi Chú Menu') }}</label>

                            <div class="col-md-10">
                                <input id="menu_note" type="text" class="form-control{{ $errors->has('menu_note') ? ' is-invalid' : '' }}" placeholder="Ghi chú Menu" name="menu_note" required value="{{$menu->menu_note}}" >

                                @if ($errors->has('menu_note'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('menu_note') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="menu_route" class="col-md-2 col-form-label text-right">       <span data-toggle="tooltip" data-container="" title="" data-original-title="Nếu là Menu Thư mục thì để trống. Menu thư mục sẽ chứa các Menu Link. Menu Link thì nhập Route vào, phía sau mỗi route có dấu ;. Nếu nhiều route thì chọn route đầu là Link ">Tuyến Của Menu <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <input id="menu_route" type="text" class="form-control{{ $errors->has('menu_route') ? ' is-invalid' : '' }}" placeholder="Vd: admin/menu/create" name="menu_route"  value="{{$menu->menu_route}}"  >

                                @if ($errors->has('menu_route'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('menu_route') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="menu_order" class="col-md-2 col-form-label text-right">{{ __('Thứ tự Menu') }}</label>

                            <div class="col-md-10">
                                <input id="menu_order" type="text" class="form-control{{ $errors->has('menu_order') ? ' is-invalid' : '' }}" placeholder="Thứ tự hiển thị Menu" name="menu_order" required value="{{$menu->menu_order}}"  >

                                @if ($errors->has('menu_order'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('menu_order') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="menu_parent" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Được chọn từ Các Menu Thư Mục đã có">Meu Cha <i class="fa fa-question-circle"></i></span>
                            </label>

                            <div class="col-md-10">
                                <select id="menu_parent" name="menu_parent" class="form-control{{ $errors->has('menu_parent') ? ' is-invalid' : '' }}"   >
                                    <option value="0">Choose...</option>

                                    @foreach($menus  as $menu_parent)
                                    @if($menu->ID_Menu !=$menu_parent->ID_Menu )
                                    <option
                                    @if ($menu->menu_parent==$menu_parent->ID_Menu)
                                    selected
                                    @endif

                                    value="{{$menu_parent->ID_Menu}}">{{$menu_parent->menu_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                 @if ($errors->has('menu_parent')) 
                                    <p class='plgalert'>{{ $errors->first('menu_parent') }}</p>
                                  @endif
                            </div>

                        </div>

                        
                        

                        <div class="form-group row">
                            <label for="isactive" class="col-md-2 col-form-label text-right"> <span data-toggle="tooltip" data-container="" title="" data-original-title="Nếu là Menu Thư mục/ Menu link thì chọn hiện. Menu để lưu quyền truy cập thì chọn Ẩn.">{{ __('Hiển Thị Ra Menu') }} <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
   
                                <table class='borderchinone'><td>
                                <label for="active" class="col-form-label text-md-righ">{{ __('Hiện') }} &nbsp</label>
                                </td><td>
                                <input   type="radio"  name="menu_show" 
                                 @if ($menu->menu_show==1)
		                                   checked 
		                         @endif 
                                 value="1">
                                </td> <td style="width:20px;">
                                </td><td>
                                <label for="inactive" class="col-form-label text-md-righ">{{ __('Ẩn') }}  &nbsp</label>
                                </td><td>
                                <input   type="radio"  name="menu_show" 
                                @if ($menu->menu_show==0)
		                                   checked 
		                        @endif 
                                value="0"> 
                                 </td></table>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="isactive" class="col-md-2 col-form-label text-right">{{ __('Trạng Thái') }}</label>

                            <div class="col-md-10">
   
                                <table class='borderchinone'><td>
                                <label for="active" class="col-form-label text-md-righ">{{ __('Bật') }} &nbsp</label>
                                </td><td>
                                <input id="active" type="radio"  name="isactive"  
                                @if ($menu->menu_active==1)
		                                   checked 
		                         @endif 
                                value="1">
                                </td> <td style="width:20px;">
                                </td><td>
                                <label for="inactive" class="col-form-label text-md-righ">{{ __('Tắt') }}  &nbsp</label>
                                </td><td>
                                <input id="inactive" type="radio"  name="isactive" 
                                @if ($menu->menu_active==0)
		                                   checked 
		                         @endif 
                                value="0"> 
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
@endsection

@section ('script')