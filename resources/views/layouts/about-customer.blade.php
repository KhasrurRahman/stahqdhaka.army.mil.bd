@extends('layouts.customer-master')
@section('content')
        <div class="col-md-10" id="content_term_condition" style="margin-top:10px; ">  	
        <div class="content-area" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="pptitle">About Me</h3>
            </div>
            <div class="panel-body" style="padding:15px;">
             <div class="container-fluid">
             <div class="row">
              <div class="col-md-3">
                <span>Applicant Full Name</span>
              </div>
              <div class="col-md-9">
               <span> {{!empty(auth()->guard('applicant')->user()->name)?auth()->guard('applicant')->user()->name:''}} </span>
             </div>
              <div class="col-md-3">
                <span>User Name</span>
              </div>
              <div class="col-md-9">
               <span> {{!empty(auth()->guard('applicant')->user()->user_name)?auth()->guard('applicant')->user()->user_name:''}} </span>
             </div>
              <div class="col-md-3">
                <span>Phone Number</span>
              </div>
              <div class="col-md-9">
               <span> {{!empty(auth()->guard('applicant')->user()->phone)?auth()->guard('applicant')->user()->phone:''}} </span>
             </div>
              <div class="col-md-3">
                <span>Email Address</span>
              </div>
              <div class="col-md-9">
               <span> {{!empty(auth()->guard('applicant')->user()->email)?auth()->guard('applicant')->user()->email:''}} </span>
             </div>
              <div class="col-md-3">
                <span>User Type</span>
              </div>
              <div class="col-md-9">
               <span> {{!empty(auth()->guard('applicant')->user()->role)?auth()->guard('applicant')->user()->role:''}} </span>
             </div>
              
            </div>
        </div>

       </div>
        

    </div>


				</div>
	
@endsection