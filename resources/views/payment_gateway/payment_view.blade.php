@extends('layouts.customer-master')
@section('content')
    <style>
        {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .page {
            border: 1px solid rgb(215, 215, 215);
            box-shadow: 0 0 10px 1px rgba(0, 0, 0, .1);
        }

        .plan-1 {
            width: 60%;
            margin: 0 auto;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffff;
            height: 50px;
            background-color: #a72016;
        }

        .page-title {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffff;
            height: 50px;
            background-color: #16A751;
        }

        .content {
            display: flex;
        }

        .contain-l {

            min-height: 300px;

        }

        .contain-r {

            background-color: #bf1616;
            min-height: 300px;
            border-left: 1px solid rgb(215, 215, 215);
            color: white;

        }

        .contain-r div h4 {

            border-bottom: 1px solid #33880A;
        }

        .info-l {
            display: flex;
            flex-direction: column;
            row-gap: 10px;
            width: 75%;
            margin: 0 auto;
        }

        table {
            width: 100%;

        }

        .table tr td h5 {

            padding: 0;
            margin: 0;
            color: #ffffff;


        }

        .table tr td {


            color: #ffffff;


        }

        .table tr td p {
            color: #61d925;
        }

        .persional-details .table tr td h5 {
            color: #252625;
            padding: 0;
            margin: 0;

        }

        .persional-details .table tr td {
            color: #252625;
            text-align: center
        }

        .plan {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #33880A;
            width: 100%;
            margin: 0 auto;
            height: 50px;
        }

        .button {
            background-color: #33880A;
            color: #ffffff;

        }

        @media (max-width: 767.99px) {
            .content {
                flex-direction: column;
            }
        }
    </style>


    <div class="container mt-5 payment_gateway">
        <div class="page">
            <div class="col-12  page-title">
                <h3>Payment Page</h3>
            </div>

            @if (Session::has('alert'))
                <div class="alert alert-danger text-center" role="alert">
                    {{ Session::get('alert') }}
                </div>
            @endif
            
            @if (Session::has('message'))
                <div class="alert alert-success text-center" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            <form action="{{ route('make_payment') }}" method="post">
                <div class=" content">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-7 contain-l">
                        <div class="plan-1">
                            <h4>Personal Details</h4>
                        </div>

                        <input type="hidden" name="name" value="{{ $application->applicant->name }}">
                        <input type="hidden" name="reg_number" value="{{ $application->vehicleinfo->reg_number }}">
                        <input type="hidden" name="phone" value="{{ $application->applicant->phone }}">
                        <input type="hidden" name="amount" value="{{ $application->stickerCategory->price }}">
                        <input type="hidden" name="application_id" value="{{ $application->id }}">

                        <div class="persional-details">
                            <table class="table">
                                <tr>
                                    <td>
                                        <h5>Name:</h5>
                                    </td>
                                    <td>
                                        {{ $application->applicant->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Reg No:</h5>
                                    </td>
                                    <td>
                                        {{ $application->vehicleinfo->reg_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Phone No:</h5>

                                    </td>
                                    <td>
                                        {{ $application->applicant->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Apply Date:</h5>

                                    </td>
                                    <td>
                                        {{ $application->app_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Vehicle Type:</h5>

                                    </td>
                                    <td>
                                        {{ $application->vehicleType->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>National Id:</h5>

                                    </td>
                                    <td>
                                        {{ $application->applicant->applicantDetail->nid_number }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="col-12 col-sm-12 col-md-6  col-lg-5 contain-r">
                        <div class="m-5 info-r">
                            <div class="plan">
                                <h4>Price</h4>
                            </div>

                            <div>
                                <table class="table">
                                    <tr>
                                        <td>
                                            <h5>Price</h5>
                                            <p>Details Of payment</p>

                                        </td>
                                        <td>
                                            {{ $application->stickerCategory->price }}
                                        </td>
                                    </tr>

                                </table>
                                <div style="margin: 0 auto;">
                                    <button type="submit" class="btn btn-primary btn-block" id="pay_now_button">Pay
                                        now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
