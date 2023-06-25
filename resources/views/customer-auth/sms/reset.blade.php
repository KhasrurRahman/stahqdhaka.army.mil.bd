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

                        <form method="POST" action="{{ route('customer.password.sms.reset.post') }}">
                            {{csrf_field()}}

                            <input type="hidden" name="token" value="{{ request()->get('token') }}">

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required AUTOCOMPLETE="off">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required AUTOCOMPLETE="off">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Reset Password
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
