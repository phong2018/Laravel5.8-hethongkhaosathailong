@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tra cứu hồ sơ</h1>
    <form method="POST" action=""   enctype="multipart/form-data">
        @csrf
        <div class="form-group row" style="padding-top: 20px">
            <label for="address" class="col-md-2 col-form-label  ">Mã Hồ Sơ</label>
            <div class="col-md-10">
                <input id="mahoso"  value="<?php echo $data['mahoso'];?>" type="text" class="form-control{{ $errors->has('mahoso') ? ' is-invalid' : '' }}" name="mahoso"  >
                @if ($errors->has('mahoso'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('mahoso') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-md-2 col-form-label  ">Số điện thoại</label>
            <div class="col-md-10">
                <input id="sodienthoai" value="<?php echo $data['sodienthoai'];?>" type="text" class="form-control{{ $errors->has('sodienthoai') ? ' is-invalid' : '' }}" name="sodienthoai"  >
                @if ($errors->has('mahoso'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sodienthoai') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-0 ">
            <div class="col-md-12 offset-md-12">
                <button type="submit" class="btn btn-primary subm100" style=" margin-left:0px !important;background-color: #1ab394;
    border-color: #1ab394;
    color: #FFFFFF;">
                    Tìm Kiếm
                </button>
            </div>
        </div>




    </form>
    <br>
    @if(isset($dossier) && count($dossier)>0)
    <h4>Kết quả tìm kiếm hồ sơ</h4>
    <table class='table panel panel-default tbtkhs' style="background: white;font-size: 5vw">

   <tr>
    <td>Mã Hồ Sơ</td>
       <td>{{$dossier->Ma_Hoso}}</td>
    </tr><tr>
            <td>Tên tdủ tục</td>
       <td>{{$dossier->dossier_name}}</td>
    </tr><tr>  
        <td>Chủ hồ sơ</td>
       <td>{{$dossier->dossier_owner}}</td>
    </tr><tr>
        <td>Số điện tdoại</td>
       <td>{{$dossier->owner_phone}}</td>
    </tr><tr>
        <td>Tình trạng</td>
       <td>{{$dossier->step_name}}</td>
    </tr>
    </table>
    @else
    <h4>Không tìm thấy Hồ sơ</h4>
    @endif



</div>
@endsection
