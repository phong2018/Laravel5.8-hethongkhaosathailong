@extends ('admin.layouts.index')

@section ('title')
<title>tdêm Vai Trò</title>
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
                <form  action="{{ route('role.store')}}" accept-charset="UTF-8" method="POST" enctype="multipart/form-data">    

                    @csrf

                    <div class="form-group row">
                        <label for="role_name" class="col-md-2 col-form-label text-md-right">{{ __('Tên Quyền') }}</label>

                        <div class="col-md-10">
                            <input id="role_name" type="text" class="form-control{{ $errors->has('role_name') ? ' is-invalid' : '' }}" name="role_name" required>

                            @if ($errors->has('role_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role_name') }}</strong>
                            </span>
                            @endif

                            @if(session('messenger'))
                            <p class='plgalert'>{{session('messenger')}}</p>
                            @endif
                        </div>
                    </div>

                   
 
     
                    <div class="form-group row" >
                    <label for="role_name" class="col-md-2 col-form-label text-md-right">{{ __('Quyền Truy Cập') }}</label>
                    <div class="col-md-10">
                    <div class='plgscrollbar'>
                       <table class='borderchinone'>
                        <tr class='headertb'><td>Tên Menu</td><td>Ghi Chú</td><td> Route Menu</td><td><input id='checkall' type="checkbox" /></td></tr> 
                        @if(count($menu) > 0)
                        @foreach($menu as $val)
                        <tr><td>{{$val->menu_name}}</td><td>{{$val->menu_note}}</td><td>  {{$val->menu_route}}  </td><td>
                        <input class='cbmenu' type="checkbox" name="menus[]" value='{{$val->ID_Menu}}' />
                        </td></tr>
                        @endforeach
                        @endif
                        </table>
                        </div>    
                    </div>
                    </div>


                   


                    <div class="form-group row">
                        <label for="isactive" class="col-md-2 col-form-label text-right">{{ __('Trạng Thái') }}</label>

                        <div class="col-md-10">

                            <table class='borderchinone'><td>
                            <label for="active" class="col-form-label text-md-righ">{{ __('Bật') }} &nbsp</label>
                            </td><td>
                            <input   type="radio"  name="role_active" checked="checked" value="1">
                            </td> <td style="width:20px;">
                            </td><td>
                            <label for="inactive" class="col-form-label text-md-righ">{{ __('Tắt') }}  &nbsp</label>
                            </td><td>
                            <input   type="radio"  name="role_active" value="0"> 
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
<script>
var check=1;
$("#checkall").click(function(){
 
  if(check==1){
    $('.cbmenu:input:checkbox').each(function() { this.checked = true; });
    check=0;
  }else{
     $('.cbmenu:input:checkbox').each(function() { this.checked = false; });
     check=1;
  }
   
});
</script>
@endsection

@section ('script')