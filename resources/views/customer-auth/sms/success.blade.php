@extends('layouts.master')

@section('content')

    @include('layouts.header')
    @include('layouts.newsticker')
    <div class="container">
        <div class="row  mt-3 justify-content-center">
            <div class="col-md-8">
                <div class="card" style="margin: 80px auto;">
                    <div class="card-header">Customer Reset Password</div>

                    <div class="card-body">
                        <div class="alert alert-success">
                            Password Successfully Reset
                        </div>

                        <a class="btn btn-primary" href="{{ route('customer.login') }}">Go To Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
