@extends('layouts.master')

@section('content')

    @include('layouts.header')
    @include('layouts.newsticker')
    <div class="container">
        <div class="row  mt-3 justify-content-center">
            <div class="col-md-8">
                <div class="card" style="margin: 80px auto;">
                    <div class="card-header">Customer Reset Password</div>

                    <div class="alert alert-info">
                        A verification code has been sent to your phone. Please verify within 300 seconds to proceed.
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-danger">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.password.sms.verify.post') }}">
                            {{csrf_field()}}

                            <div class="form-group row">
                                <label for="code" class="col-md-4 col-form-label text-md-right">Verification Code</label>

                                <div class="col-md-6">
                                    <input id="code" type="text" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" value="{{ old('code') }}" required>

                                    @if ($errors->has('code'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Verify
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
