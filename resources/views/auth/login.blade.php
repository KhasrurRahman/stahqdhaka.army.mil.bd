@extends('layouts.master')
@section('content')
@include('layouts.header')
@include('layouts.newsticker')
<style>
    .scrolltotop i {
        position: relative;
        top: 8px;
    }
</style>
<div class="wrapper" id="login-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" >
                <div class="bar login-div">
                    <i class="fa fa-user"></i> Admin Login
                </div>
                <div class="well login-div">

                    <form method="POST" action="{{ route('login') }}">
                        {{csrf_field()}}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-Mail Address</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>

                            <input id="password" type="password" class="form-control" name="password" autocomplete="off" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' :'' }}> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                            <hr>
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
