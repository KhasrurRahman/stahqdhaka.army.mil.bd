<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\ApplicantDetail;
use App\Application;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //


    public function paymentView($id)
    {

        $application = Application::find($id);

        return view('payment_gateway.payment_view', compact('application'));
    }
}
