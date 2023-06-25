@extends('layouts.admin-master')
@section('admin-sidebar')
  @include('layouts.admin-sidebar')
@endsection
@section('style')
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
    <div class="content-area">
        <!-- search-form starts -->
        <div class="container-fluid" id="search-form">
            <form action="{{url('renew/sms')}}" method="POST">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn btn-sm btn-success" disabled> {{ $total_renew }} </button>
                        <br><br>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> Skip Quantity </label>
                            <input type="number" class="form-control" name="skip" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> SMS Quantity </label>
                            <input type="number" class="form-control" name="quantity" value="100" required>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <br><br><br>
                        <button type="submit" class="btn btn-primary mb-4">Send Renew SMS</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                       @if(session('success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{session('success')}}
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div><!-- search-form  -->
    </div>

@endsection

@section('admin-script')
@endsection

