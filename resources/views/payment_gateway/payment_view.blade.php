@extends('layouts.customer-master')
@section('content')
    {{-- <link rel="stylesheet" href="./style.css"> --}}


    <div class="container mt-5 payment_gateway">
        <div class="page">
            <div class="col-12  page-title ">
                <h3>Payment Page</h3>
            </div>
            <form action="">
                <div class=" content">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-7 contain-l">

                        {{-- <div class="mt-5 mb-5 info-l">
                        <div>
                            <label for="name">Name :</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div>
                            <label for="mobile">Reg No :</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile (Ex: 016*******1)">
                        </div>
                        <div>
                            <label for="mobile">Phone No :</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile (Ex: 016*******1)">
                        </div>

                        <div>
                            <label for="mobile">Apply Date :</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile (Ex: 016*******1)">
                        </div>
                        <div>
                            <label for="">Selection : </label>
                            <select name="" id="" class="form-control">
                                <option value="">Select One</option>
                                <option value="">Select One</option>
                                <option value="">Select One</option>
                            </select>
                        </div>
                        <div>
                            <label for="input-group"> Address :</label>
                            <div class="input-group">

                                <input type="text" class="form-control" placeholder="City" aria-label="Username">

                                <input type="text" class="form-control" placeholder="Area" aria-label="Server">
                            </div>
                        </div>
                    </div> --}}

                        <div class="plan-1">
                            <h4>Personal Details</h4>
                        </div>

                        <div class="persional-details">
                            @if(isset(auth()->guard('applicant')->user()->applications))
                            <?php $sl=1; ?>
                            @foreach(auth()->guard('applicant')->user()->applications->sortByDesc('created_at') as $key => $app)
                                <table class="table">
                                    <tr>
                                        <td>
                                            <h5>Name:</h5>
                                        </td>
                                        <td>
                                            {{!empty($app->applicant->name)?$app->applicant->name:''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>Reg No:</h5>
                                        </td>
                                        <td>
                                            {{!empty($app->vehicleinfo->reg_number)?$app->vehicleinfo->reg_number:''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>Phone No:</h5>

                                        </td>
                                        <td>
                                            {{!empty($app->applicant->phone)?$app->applicant->phone:""}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>Apply Date:</h5>

                                        </td>
                                        <td>
                                            {{!empty($app->app_date)?$app->app_date:""}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>Vehicle Type:</h5>

                                        </td>
                                        <td>
                                            {{!empty($app->vehicleinfo->vehicleType->name)?$app->vehicleinfo->vehicleType->name:''}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5>National Id:</h5>

                                        </td>
                                        <td>
                                            {{ isset($app->applicant->applicantDetail->nid_number) ? $app->applicant->applicantDetail->nid_number : '-' }}
                                        </td>
                                    </tr>

                                    


                                </table>

                            @endforeach
                            @endif
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
                                            $ 100.00
                                        </td>
                                    </tr>

                                </table>


                                <div style="margin: 0 auto;">
                                    <Button class="btn button p-2">PAY NOW</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
@endsection
