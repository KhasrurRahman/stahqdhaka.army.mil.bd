<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function paymentView()
    {
        return view('payment_gateway.payment_view');
    }
}
