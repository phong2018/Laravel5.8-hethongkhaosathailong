@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Đăng ký') }}</div>
                @if(count($errors) > 0)
                @foreach($errors->all() as $err)
                <div class="alert alert-danger">{{$err}}</div>
                @endforeach
                @endif
                <div class="card-body">
                    <form method="POST" action="register" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="staff_id" class="col-md-4 col-form-label text-md-right">{{ __('ID Staff') }}</label>

                            <div class="col-md-6">
                                <input id="staff_id" type="text" class="form-control{{ $errors->has('staff_id') ? ' is-invalid' : '' }}" name="staff_id"required >

                                @if ($errors->has('staff_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('staff_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fullname" class="col-md-4 col-form-label text-md-right">{{ __('Employee Name') }}</label>

                            <div class="col-md-6">
                                <input id="fullname" type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" required >

                                @if ($errors->has('fullname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fullname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Day of Birth') }}</label>

                            <div class="col-md-6">
                                <input id="dob" type="date" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" required >

                                @if ($errors->has('dob'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('Sex') }}</label>

                            <div class="col-md-6">
                                <label for="male" class="col-md-4 col-form-label text-md-right">{{ __('Male') }}</label>
                                <input id="male" type="radio"  name="sex" checked="checked" value="1">

                                <label for="female" class="col-md-4 col-form-label text-md-right">{{ __('Female') }}</label>
                                <input id="female" type="radio"  name="sex" value="0"> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" required>

                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" required>

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zalo" class="col-md-4 col-form-label text-md-right">{{ __('zalo id') }}</label>

                            <div class="col-md-6">
                                <input id="zalo" type="text" class="form-control{{ $errors->has('zalo') ? ' is-invalid' : '' }}" name="zalo" required>

                                @if ($errors->has('zalo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('zalo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('avatar') }}</label>

                            <div class="col-md-6">
                                <input id="avatar" type="text" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" name="avatar" required>

                                @if ($errors->has('avatar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <select id="position" name="position" class="form-control">
                                    <option >Choose...</option>
                                    <option value="1">Chủ Tịch</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select id="role" name="role"  class="form-control">
                                    <option>Choose...</option>
                                    <option value="1">Manager</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirm" type="password" class="form-control" name="password_confirm" required>
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
@endsection
