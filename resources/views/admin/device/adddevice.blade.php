@extends ('admin.layouts.index')

@section ('title')
<title>Thêm Thiết bị</title>
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
                    <form method="POST" onsubmit="return validateForm()" action="{{ route('device.store')}}"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                                <label for="device_name" class="col-md-2 col-form-label text-md-right">{{ __('Tên Thiết bị') }}</label>

                                <div class="col-md-10">
                                    <input id="device_name" placeholder="Tên Thiết bị" type="text" class="form-control{{ $errors->has('device_name') ? ' is-invalid' : '' }}" name="device_name" required>

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
                                    <input id="device_uid"  readonly  placeholder="Mã Thiết bị" type="text" class="form-control{{ $errors->has('device_uid') ? ' is-invalid' : '' }}" name="device_uid" required>

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
                                    <input id="device_registerDate" placeholder="Tên Thiết bị" type="date" class="form-control{{ $errors->has('device_registerDate') ? ' is-invalid' : '' }}" name="device_registerDate" required>

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
                                            <option  value="{{$x}}"> {{$tengoi[$x]}}
                                            </option>
                                        <?php }?>
                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group row">
                            <label for="device_assign_userid" class="col-md-2 col-form-label text-md-right"><span data-toggle="tooltip" data-container="" title="" data-original-title="Chọn Nhân viên">Chọn nhân viên quản lý<i class="fa fa-question-circle"></i></span></label>

                            <div class="col-md-10">
                                <select id="device_assign_userid" name="device_assign_userid" class="form-control"   >
                                    <option value="">Choose...</option><?php
                                    try {
                                        foreach ($org as $no => $org) { ?>

                                            <option value="">{{$org->org_name}}</option>
                                            <?php foreach ($org_user[$no] as $us) { ?>
                                                <option value="{{$us->id}}"> ++ {{$us->fullname}}</option>
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
                              <label class="col-sm-2 control-label" for="input-device_orgid" style='text-align: right'><span data-toggle="tooltip" title="" data-original-title="Chọn đơn vị khảo sát cho thiết bị này.">Chọn đơn vị khảo sát</span></label>

                                  <div class="col-md-10">
                                      <select id="device_orgid"  name="device_orgid" class="form-control{{ $errors->has('device_orgid') ? ' is-invalid' : '' }}" required>
                                          <option value="">Choose...</option>
                                          @foreach($data['orgs'] as $no=>$val)
                                          <option  value="{{($val['org_id'])}}">{{$val['org_name']}}</option>
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
                                    <input id="active" type="radio"  name="device_isActived" checked="checked" value="1">
                                    </td> <td style="width:20px;">
                                    </td><td>
                                    <label for="inactive" class="col-form-label text-md-righ">{{ __('Tắt') }}  &nbsp</label>
                                    </td><td>
                                    <input id="inactive" type="radio"  name="device_isActived" value="0"> 
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
<script>

    <?php
    
    //echo "alert('".$string."')";
    ?>;
    function validateForm(){
        localStorage.setItem("divideid", $('#device_uid').val());
        return true;
    }
// Check browser support
    var divideid;
    // Check browser support
    if (typeof(Storage) !== "undefined") {
          
          // Retrieve
          if(localStorage.getItem("divideid")){
                //alert('co id');
                divideid=localStorage.getItem("divideid");

                if(divideid.length>5){
                    divideid=(Math.random().toString(36).substring(2, 4) + Math.random().toString(36).substring(2,5)).toUpperCase();

                    localStorage.setItem("divideid",  divideid);

                }
          }
          else{
            divideid=(Math.random().toString(36).substring(2, 4) + Math.random().toString(36).substring(2,5)).toUpperCase();
            //alert(divideid);
          }
            //divideid=(Math.random().toString(36).substring(2, 3) + Math.random().toString(36).substring(2, 16)).toUpperCase();
          //-------kiểm tra xem có mã chưa nếu có rồi thì thông báo
          $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
          var urll="{{ url('ajax/checkdevice') }}/"+divideid;//alert(urll);
          $.ajax({
                url: urll,
                type: "GET",
                data: {},//'active' : id
                success:function (data) {//alert("YES");//alert(data['success']);
                     
                    if(data['device_isactived']==0){
                        $('#device_name').val(navigator.appCodeName+" "+navigator.appVersion);
                        $('#device_uid').val(divideid);
                        var today = new Date();
                        $('#device_registerDate').val(new Date().toISOString().substring(0, 10));

                    }
                    else{
                        alert('Thiết bị này đã được quản lý trên hệ thống. Hệ thống sẽ chuyển đến trang để cập nhật thiết bị này!');
                        window.location.href = "{{ URL::to('admin/device')}}/"+data['device_id']+"/edit";

                    }
                   
                },
                error:function () {//alert("NO");
                    //alert(0);
                    alert("NOO");
                    console.log("i cant's run. Please check bug!");
                }
            });

    } else {
      alert("Xin lỗi, cần nâng cấp Trình duyệt để sử dụng hệ thống");
    }
    
    

</script>
@endsection

@section ('script')