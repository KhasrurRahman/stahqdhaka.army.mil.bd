@extends('layouts.master')
@section('content')
@include('layouts.header')
@include('layouts.newsticker')
<style>
.signup-title-div{
    max-width: 600px;
    height: 50px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border-radius: 0px;

    background-color: rgb(209, 4, 4);
}
.signup-title-div h4{
    padding: 0;
    margin: 0;
}
@media screen and (max-width: 1380px) {
    .signup-title-div{
   width: 45%;
}
}
@media screen and (max-width: 767px) {
    .signup-title-div{
   width: 400px;
}
}
</style>
<div class="wrapper" id="signup-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" >
                <div class="bar signup-div">
                    <i class="fa fa-user-plus"></i> Sign Up
                </div>
                <div class="bar signup-title-div">
                   <b>if you have registered already , please don't need to register again</b> 
                </div>
                <div class="well signup-div">

                    <form method="POST" action="{{ route('customer.register') }}">
                      {{csrf_field()}}

                      <div class="row">
                        <div class="col-md-6 form-group">
                            <label>User Name</label> <span style="color: red;">*</span>
                            <input type="text" name="user_name" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" placeholder="Enter your name">

                            @if ($errors->has('user_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('user_name') }}</strong>
                            </span>
                            @endif

                        </div>
                        <div class="col-md-6 form-group">
                            <label>Applicant Full Name</label> <span style="color: red;">*</span>
                            <input type="text" name="Applicant_Full_Name" class="form-control{{ $errors->has('Applicant_Full_Name') ? ' is-invalid' : '' }}" placeholder="Enter your name">

                            @if ($errors->has('Applicant_Full_Name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('Applicant_Full_Name') }}</strong>
                            </span>
                            @endif

                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label> 
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="you@example.com">
                            @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>



                    <div class="row">

                       <div class="col-md-12 form-group">
                        <label>Mobile</label> <span style="color: red;">*</span>
                        <input type="text" name="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Ex: 018XXXXXXXX">
                        @if ($errors->has('phone'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                        @endif
                    </div>          
                </div>

                <div class="row">
                    
                 <div class=" col-md-12 form-group">
                    <label>Password</label> <span style="color: red;">*</span>
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" AUTOCOMPLETE="off" placeholder="Create a password" AUTOCOMPLETE="off">
                    
                </div> 
            </div> 
            <div class="row">
                
             <div class=" col-md-12 form-group">
                <label>Confirm Password</label> <span style="color: red;">*</span>
                <input type="password" class="form-control" name="password_confirmation" AUTOCOMPLETE="off" placeholder="Confirm password">

                @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>    
        <div class="row">
         <div class=" col-md-12 ">
             <label>User Type </label> <span style="color: red;">*</span> &nbsp;&nbsp;
             <input type="checkbox"  class="form-group chb role" id="defsel" name="role" value="def"> <label for="defsel">Def. Person?</label> &nbsp;
             <input type="checkbox"  class="form-group chb role" id="nondefsel" name="role" value="non-def"> <label for="nondefsel"> Non Def. Person?</label>
             @if ($errors->has('role'))
             <span class="invalid-feedback">
                <strong>{{ $errors->first('role') }}</strong>
            </span>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <button type="submit" id="submit" disabled class="btn btn-primary btn-block">Submit</button>
        </div>
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4">
            &nbsp;
        </div>
    </div>

    <hr>

    Already have an account? <a class="btn btn-info" href="{{route('customer.login')}}">Log in.</a>

</form>
</div>
</div>
</div>
</div>
</div>
@endsection
