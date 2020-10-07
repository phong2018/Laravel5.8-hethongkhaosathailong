@extends ('admin.layouts.index')

@section ('title')
<title>thêm hồ sơ mới</title>
@endsection
@section ('style')

@endsection

@section ('content')
<div class="container">
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
  
        <div class="col-md-12">
            <div class="card">
                
                @if(count($errors) > 0)
                @foreach($errors->all() as $err)
                <div class="alert alert-danger">{{$err}}</div>
                @endforeach
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('user.store')}}"  enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ID_Staff" class="col-md-2 col-form-label text-md-right">{{ __('Mã Nhân Viên') }}</label>

                            <div class="col-md-10">
                                <input id="ID_Staff" type="text" class="form-control{{ $errors->has('ID_Staff') ? ' is-invalid' : '' }}" name="ID_Staff"required >

                                @if ($errors->has('ID_Staff'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('ID_Staff') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fullname" class="col-md-2 col-form-label text-md-right">{{ __('Tên Nhân Viên') }}</label>

                            <div class="col-md-10">
                                <input id="fullname" type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" required >

                                @if ($errors->has('fullname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fullname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="DoB" class="col-md-2 col-form-label text-md-right">{{ __('Ngày Sinh') }}</label>

                            <div class="col-md-10">
                                <input id="DoB" type="date" class="form-control{{ $errors->has('DoB') ? ' is-invalid' : '' }}" name="DoB" required >

                                @if ($errors->has('DoB'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('DoB') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-2 col-form-label text-md-right">{{ __('Giới Tính') }}</label>

                            <div class="col-md-10">
                                <table class='borderchinone'><td>
                                <label for="male" class="  col-form-label text-md-right">{{ __('Nam ') }} &nbsp </label>
                                </td><td>
                                <input id="male" type="radio" class='inputsex' name="sex" checked="checked" value="1">
                                </td> <td style="width:20px;">

                                </td><td>
                                <label for="female" class=" col-form-label text-md-right">{{ __('Nữ') }}&nbsp </label>
                                </td><td>
                                <input id="female" type="radio" class='inputsex' name="sex" value="0"> 
                                </td></table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="chonkhaosat" class="col-md-2 col-form-label text-md-right">{{ __('Chọn để khảo sát') }}</label>

                            <div class="col-md-10">
                                <table class='borderchinone'><td>
                                <label for="male" class="  col-form-label text-md-right">{{ __('Chọn ') }} &nbsp </label>
                                </td><td>
                                <input id="male" type="radio" class='inputchonkhaosat' name="chonkhaosat" checked="checked" value="1">
                                </td> <td style="width:20px;">

                                </td><td>
                                <label for="female" class=" col-form-label text-md-right">{{ __('Không chọn') }}&nbsp </label>
                                </td><td>
                                <input id="female" type="radio" class='inputchonkhaosat' name="chonkhaosat" value="0"> 
                                </td></table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-2 col-form-label text-md-right">{{ __('Địa Chỉ') }}</label>

                            <div class="col-md-10">
                                <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" >

                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label text-md-right">{{ __('Số Điện Thoại') }}</label>

                            <div class="col-md-10">
                                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" >

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zalo" class="col-md-2 col-form-label text-md-right">{{ __('Zalo') }}</label>

                            <div class="col-md-10">
                                <input id="zalo" type="text" class="form-control{{ $errors->has('zalo') ? ' is-invalid' : '' }}" name="zalo" >

                                @if ($errors->has('zalo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('zalo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="chucdanh" class="col-md-2 col-form-label text-md-right">{{ __('Chức danh') }}</label>

                            <div class="col-md-10">
                                <input id="chucdanh" type="text" class="form-control{{ $errors->has('chucdanh') ? ' is-invalid' : '' }}" name="chucdanh">

                                @if ($errors->has('chucdanh'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('chucdanh') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="avatar" class="col-md-2 col-form-label text-md-right">{{ __('Avatar') }}</label>

                            <div class="col-md-10">

                                 <div class="input-group">
                                      <input type="button" id="lfm" data-input="thumbnail" data-preview="holder" value="Upload">
                                      <input type="hidden" id="thumbnail" class="form-control" value="" type="text" name="avatar">
                                  </div>
                                  <img id="holder" src=" " style="margin-top:15px;max-height:100px;">
                                 
                            </div>
                        </div>  

                        <div class="form-group row">
                            <label for="user_IdOrg" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Đơn vị">Đơn vị <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <select id="user_IdOrg" name="user_IdOrg" class="form-control"  required>
                                    <option value="">Choose...</option>
                                    <?php
                                    try {
                                        foreach ($org as $no=>$org) { ?>
                                            <option value="{{$org->org_id}}">{{$org->org_name}}</option>
                                            <?php foreach ($org_child[$no] as $orgc) { ?>
                                                <option value="{{$orgc->org_id}}"> ++ {{$orgc->org_name}}</option>
                                            <?php } ?>    
                                            
                                        <?php }
                                    ?> 
                                    <?php } catch (Exception $e) { ?>
                                        <option value="1">thằng nào đó</option>
                                        <option></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Có nhiều Chức vụ: Lãnh đạo Đơn vị, Phó Lãnh đạo Đơn vị, Chuyên viên, Cán bộ.. Được tạo trong Menu Chức Vụ">Chức Vụ <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <select id="position" name="position" class="form-control"  required>
                                    <option value="">Choose...</option><?php
                                    try {
                                        foreach ($position as $pos) { ?>
                                            <option value="{{$pos->ID_Pos}}">{{$pos->pos_name}}</option>
                                            
                                        <?php }
                                        ?> <option></option><?php
                                    } catch (Exception $e) { ?>
                                        <option value="1">thằng nào đó</option>
                                        <option></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-2 col-form-label text-md-right"> <span data-toggle="tooltip" data-container="" title="" data-original-title="Có nhiều Vai trò: Quản trị, lãnh đạo, giám sát, nhân viên,... Vai trò được gán với quyền truy cập Menu cụ thể. Quản lý Vai trò trong Menu Vai Trò">Vai Trò <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <select id="role" name="role"  class="form-control"  required>
                                    <option value="">Choose...</option><?php
                                    try {
                                        foreach ($roles as $key) { ?>
                                            <option value="{{$key->ID_Role}}">{{$key->role_name}}</option><?php
                                        }
                                    } catch (Exception $e) { ?>
                                        <option value="1">Manager</option>
                                        <option></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Có 2 Cấp bậc: 1: Quản trị hệ thống (toàn quyền). 2: Người dùng (phân quyền theo  Vai trò). Bao gồm: Lãnh đạo, giám sát, nhân viên">Cấp Bậc <i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <select id="user_level" name="user_level"  class="form-control"  required>
                                    <option value="">Choose...</option> 
                                    <?php 
                                    $tengoi=array();
                                    $tengoi[2]='Người Dùng';    
                                    $tengoi[1]='Quản Trị'; 
                                    if(Auth::user()->user_level
                                        ==1){
                                        $dau=2;$cuoi=1;
                                    }else{$dau=2;$cuoi=2;}

                                    for ($x = $dau; $x>=$cuoi; $x--) { ?>
                                        <option  value="{{$x}}">{{$tengoi[$x]}}
                                        </option>
                                    <?php }?>
                                    
                                </select>
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Mật Khẩu') }}</label>

                            <div class="col-md-10">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Đăng ký') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{url('/')}}/public/vendor/laravel-filemanager/js/lfm.js"></script>
    <script>
        var options = {prefix:"{{url('/public/')}}"}
        $('#lfm').filemanager('image',options); 
    </script> 

@endsection

@section ('script')