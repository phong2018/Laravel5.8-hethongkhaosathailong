@extends ('admin.layouts.index')

@section ('title')
<title>phân quyền sử dụng menu</title>
@endsection

@section ('style')

@section ('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-xs-12 col-lg-12">
        <div class="card">
            @if(count($errors) > 0)
            @foreach($errors->all() as $err)
            <div class="alert alert-danger">{{$err}}</div>
            @endforeach
            @endif
            <div class="card-body">
                <form method="POST" action="add" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label  class="col-md-4 col-form-label text-md-right">{{ __('NHÂN VIÊN') }}</label>

                            @foreach ($employee as $r)
                            <div class="form-group group-checkbox-left">
                                <input id="employ" type="radio" name="employee" value="{{$r->id}}">
                                <label for="employ" class="col-md-6 col-form-label text-center">{{$r->fullname}}</label>
                            </div>

                            @endforeach

                        </div>
                        <div class="col-md-6">
                            <label for="sector_name" class="col-md-4 col-form-label text-md-right">{{ __('THỦ TỤC') }}</label>

                            <div>
                                @foreach ($procedure as $k)
                                <div class="form-group group-checkbox-left">
                                    <input id="menu" type="checkbox" name="procedure[]" value="{{$k->ID_Procedure}}">
                                    <label for="menu" class="col-md-6 col-form-label text-center">{{$k->procedure_name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Lưu Lại') }}
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Quay Lại
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section ('script')