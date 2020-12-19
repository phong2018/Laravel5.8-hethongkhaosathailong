@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 70px;">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="text-align: center;">{{ __('Đặt lại Mật khẩu') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}" style="border:none;">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class=" plghidden col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-12">
                                <input id="email" placeholder="Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class=" plghidden  col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" placeholder="Mật khẩu" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class=" plghidden col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-12">
                                <input id="password-confirm" placeholder="Nhập lại mật khẩu" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-12">
                                <button type="submit" class="btn btn-primary"  style="width:100%;margin-left:0px !important;background-color: #1ab394;
    border-color: #1ab394;
    color: #FFFFFF;">
                                    {{ __('Đặt lại Mật Khẩu') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
