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
                        @if (session('status'))
                            <div class="alert alert-danger">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.password.sms.send.verification_code') }}">
                            {{csrf_field()}}

                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">Login Mobile Number</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" required>

                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Verification Code
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
