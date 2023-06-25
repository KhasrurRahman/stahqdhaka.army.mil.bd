@extends('layouts.master')
@section('content')
@include('layouts.header')
@include('layouts.newsticker')
<style>
    #request_to_apply {
    background: #eee;
    padding: 15px;
    color: #f00;
    margin: -15px 0 25px;
    font-size: 17px;
    border-radius:10px;
}



</style>
<div class="wrapper" id="login-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" >
                <div class="bar login-div">
                    <i class="fa fa-user"></i> Login
                </div>
                <div class="well login-div">
                    @if(session()->has('verified'))
                    <div class="form-group" id="request_to_apply">
                          A verification code has been sent to your phone. Please verify within 600 seconds to proceed.
                    </div>
                        <form method="POST" action="{{ route('customer.login.verify') }}">
                            {{csrf_field()}}

                         <div class="form-group">
                            <label>Verification Code</label>
                            <input type="text" name="verify_code" class="form-control{{ $errors->has('verify_code') ? ' is-invalid' : '' }}" placeholder="Enter your Verification code">
                            @if ($errors->has('verify_code'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('verify_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit"  class="btn btn-primary btn-block">Log In</button>
                            </div>
                        </div>
                         </form>
                    @else
                        @if(Session::has('message'))
                   <div id="request_to_apply">
{{--                     <span> This is New System. All of your accounts in old system had been erased. Please <b> Create New Account</b> to log in here. </span> --}}




                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>


                   </div>
                        @endif
                    <form method="POST" action="{{ route('customer.login') }}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="+8801515XXXXXX" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter your password" autocomplete="off" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit"  class="btn btn-primary btn-block">Log In</button>
                            </div>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <a type="button"  class="btn btn-warning btn-block"  href="{{ route('customer.password.sms.index') }}"> Forgot password? </a>
                            </div>
                        </div>
                        <hr>
                        Don't have an account? <a class="btn btn-info" href="{{route('customer.register')}}">Sign up.</a>

                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>








<script src="{{url('/assets/cdn')}}/popper.min.js"></script>
</script>
@endsection



