@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 70px;">
        <div class="col-md-4">
            <div class="card">
                <strong><div class="card-header" style="text-align: center;">{{ __('Đăng Nhập') }}</div></strong>

                <div class="card-body">
                    <form method="POST" action="{{ url('login') }}" style="border:none;">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="plghidden col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="Email đăng nhập" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="plghidden  col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" placeholder="Mât khẩu"  type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                       

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-12">
                                <button type="submit" class="btn btn-primary" style="width:100%;margin-left:0px !important;background-color: #1ab394;
    border-color: #1ab394;
    color: #FFFFFF;">
                                    {{ __('Đăng Nhập') }}
                                </button>

                               
                            </div>
                        </div>
                         <div class="form-group row">
                            <div class="col-md-12">
                                <div class="" style="float:left;padding-top:5px;padding-left: 19px;">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        &nbsp &nbsp &nbsp {{ __('Nhớ mật khẩu') }}
                                    </label>
                                </div>
                                 @if (Route::has('password.request'))
                                    <a style="float:right;"  class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Quên mật khẩu') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
