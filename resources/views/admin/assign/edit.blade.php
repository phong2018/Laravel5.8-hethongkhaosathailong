@extends ('admin.index')

@section ('title')
<title>thêm lĩnh vực quản lý mới</title>
@endsection
@section ('style')

@section ('content')
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Sector') }}</div>
                @if(count($errors) > 0)
                @foreach($errors->all() as $err)
                <div class="alert alert-danger">{{$err}}</div>
                @endforeach
                @endif
                <div class="card-body">
                    <form method="POST" action="add" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="sector_name" class="col-md-4 col-form-label text-md-right">{{ __('Sector Name') }}</label>

                            <div class="col-md-6">
                                <input id="sector_name" type="text" class="form-control{{ $errors->has('sector_name') ? ' is-invalid' : '' }}" name="sector_name" required>

                                @if ($errors->has('sector_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('sector_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Lưu Lại') }}
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