<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\ApplicantDetail;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function paymentView()
    {

        $applicant = Applicant::all();
        // dd($applicant);
        $applicant_details = ApplicantDetail::all();
        return view('payment_gateway.payment_view',compact('applicant','applicant_details'));
    }
}
