@extends('layouts.customer-master')
@section('content')
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .page {
            width: 50%;
            margin: 0 auto;
            border: 1px solid rgb(215, 215, 215);
            box-shadow: 0 0 10px 0px rgba(0, 0, 0, .2);
        }

        .page-content {
            position: relative;
            width: 100%;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: end;
            color: #ffff;

        }

        .content {
            color: gray;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80%;
            width: 80%;
            margin: 25px;
            border-radius: 5px;

            background-color: white;
        }

        .circle {
            position: absolute;
            width: 100px;
            height: 100px;
            background-color: #16A751;
            border: 5px solid white;
            border-radius: 50%;
            top: 8%;

            left: 40%;
            right: 50%;

            z-index: 10;
        }
    </style>


    <div class="container mt-5 ">

        <div class="page">
            <div class="col-12  page-content ">

                <!-- Content Start -->
                <table cellpadding="0" cellspacing="0" cols="1" bgcolor="#d7d7d7" align="center" style="width: 90%;">

                    <tr bgcolor="#d7d7d7">
                        <td
                            style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">



                            <table align="center" cellpadding="0" cellspacing="0" cols="3" bgcolor="white"
                                class="bordered-left-right"
                                style="border-left: 10px solid #16A751; border-right: 10px solid #16A751; max-width: 600px; width: 100%;">
                                <tr height="50">
                                    <td colspan="3"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                    <td class="text-primary"
                                        style="color: #16A751; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                        <svg style="border: 0; font-size: 0; margin: 0; width: 25%; padding: 0;"
                                            version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50"
                                            xml:space="preserve">
                                            <circle style="fill:#16A751;" cx="25" cy="25" r="25" />
                                            <polyline
                                                style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                points="
	38,15 22,33 12,25 " />
                                        </svg>
                                    </td>
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr height="17">
                                    <td colspan="3"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                    <td class="text-primary"
                                        style="color:#16A751; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                        <h1
                                            style="color: #16A751; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 30px; font-weight: 700; line-height: 34px; margin-bottom: 0; margin-top: 0;">
                                            Payment received</h1>
                                    </td>
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr height="30">
                                    <td colspan="3"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                    <td
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                        <p
                                            style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                            Dear {{ $application->applicant->name }},
                                        </p>
                                    </td>
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr height="10">
                                    <td colspan="3"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                    <td
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                        <p
                                            style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                            Your transaction was successful!</p>
                                        <br>
                                        <p
                                            style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0; ">
                                            <strong>Payment Details:</strong><br />

                                            Amount: {{$application->stickerCategory->price }} TK <br />

                                        </p>
                                        <br>


                                        <a href="{{url('/applied-applications')}}">View Applied Application</a>


                                    </td>
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr height="30">
                                    <td
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                    <td
                                        style="border-bottom: 1px solid #D3D1D1; color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                    <td
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr height="30">
                                    <td colspan="3"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>

                                    <td width="36"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>

                                <tr height="50">
                                    <td colspan="3"
                                        style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                    </td>
                                </tr>

                            </table>



                        </td>
                    </tr>
                </table>






            </div>

        </div>

    </div>
@endsection
