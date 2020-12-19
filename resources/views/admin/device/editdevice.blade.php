@extends ('admin.layouts.index')

@section ('title')
<title>Sửa Thiết bị</title>
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
                    <form method="POST" action="{{url('admin/device', [$device->device_id])}}"   enctype="multipart/form-data">
                        
                        {{ method_field('PUT') }}{{csrf_field()}}

                        <div class="form-group row">
                                <label for="device_name" class="col-md-2 col-form-label text-md-right">{{ __('Tên Thiết bị') }}</label>

                                <div class="col-md-10">
                                    <input id="device_name" placeholder="Tên Thiết bị" type="text" class="form-control{{ $errors->has('device_name') ? ' is-invalid' : '' }}" value="{{$device->device_name}}" name="device_name" required>

                                    @if ($errors->has('device_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('device_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                          <div class="form-group row">
                                <label for="device_uid" class="col-md-2 col-form-label text-md-right">{{ __('Mã Thiết bị') }}</label>

                                <div class="col-md-10">
                                    <input id="device_uid"  readonly placeholder="Mã Thiết bị" type="text" class="form-control{{ $errors->has('device_uid') ? ' is-invalid' : '' }}" value="{{$device->device_uid}}" name="device_uid" required>

                                    @if ($errors->has('device_uid'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('device_uid') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="device_registerDate" class="col-md-2 col-form-label text-md-right">{{ __('Ngày đăng ký') }}</label>

                                <div class="col-md-10">
                                    <input id="device_registerDate" placeholder="Tên Thiết bị" type="date" value="{{substr($device->    device_registerDate,0,10)}}" class="form-control{{ $errors->has('device_registerDate') ? ' is-invalid' : '' }}" name="device_registerDate" required>

                                    @if ($errors->has('device_registerDate'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('device_registerDate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="device_giaodien" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn loại giao diện màn hình">Chọn giao diện <i class="fa fa-question-circle"></i></span></label>

                                <div class="col-md-10">
                                    <select id="device_giaodien"  name="device_giaodien"  class="form-control"  required>
                                        <option value="">Choose...</option> 
                                        <?php 
                                        $tengoi=array();
                                        $tengoi[2]='Màn hình ngang';    
                                        $tengoi[1]='Màn hình dọc';    
                                        for ($x = 1; $x<3; $x++) { ?>
                                            <option  value="{{$x}}"
                                            @if ($device->device_giaodien==$x)
                                                selected
                                                @endif
                                            > {{$tengoi[$x]}}
                                            </option>
                                        <?php }?>
                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group row">
                            <label for="device_assign_userid" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Nhân viên">Chọn nhân viên quản lý<i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <select id="device_assign_userid" name="device_assign_userid" class="form-control"  >
                                    <option value="">Choose...</option><?php
                                    try {
                                        foreach ($org as $no => $org) { ?>

                                            <option value="">{{$org->org_name}}</option>
                                            <?php foreach ($org_user[$no] as $us) { ?>
                                                <option 
                                                @if ($device->device_assign_userid==$us->id)
                                                selected
                                                @endif

                                                value="{{$us->id}}"> ++ {{$us->fullname}}</option>
                                            <?php } ?> 

                                            
                                        <?php }
                                        ?> <?php
                                    } catch (Exception $e) { ?>
                                        <option value="1">thằng nào đó</option>
                                        <option></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                            <div class="form-group row ">
                              <label class="col-sm-2 control-label" for="input-cofig_orgtosurvey" style='text-align: right'><span data-toggle="tooltip" title="" data-original-title="Chọn đơn vị khảo sát cho thiết bị này.">Chọn đơn vị khảo sát</span></label>

                                  <div class="col-md-10">
                                      <select id="device_orgid"  name="device_orgid" class="form-control{{ $errors->has('device_orgid') ? ' is-invalid' : '' }}" required>
                                          <option value="">Choose...</option>
                                          @foreach($data['orgs'] as $no=>$val)
                                          <option 
                                           @if ($val["org_id"]==$device->device_orgid)
                                           selected
                                           @endif

                                          value="{{($val['org_id'])}}">{{$val['org_name']}}</option>
                                          @endforeach
                                      </select>
                                       @if ($errors->has('device_orgid')) 
                                          <p class='plgalert'>{{ $errors->first('device_orgid') }}</p>
                                        @endif
                                  </div>

                              </div>

                        <div class="form-group row">
                                <label for="device_isActived" class="col-md-2 col-form-label text-right">{{ __('Trạng Thái') }}</label>
                                <div class="col-md-10">
                                    <table class='borderchinone'><td>
                                    <label for="active" class="col-form-label text-md-righ">{{ __('Bật') }} &nbsp</label>
                                    </td><td>
                                    <input id="active" type="radio"  name="device_isActived" checked="checked" <?php if($device->device_isActived==1) echo "checked";?>  value="1">
                                    </td> <td style="width:20px;">
                                    </td><td>
                                    <label for="inactive" class="col-form-label text-md-righ">{{ __('Tắt') }}  &nbsp</label>
                                    </td><td>
                                    <input id="inactive" type="radio" <?php if($device->device_isActived==0) echo "checked";?>  name="device_isActived" value="0"> 
                                     </td></table>

                                </div>
                            </div>
                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Lưu lại') }}
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
</div>
@endsection

@section ('script')