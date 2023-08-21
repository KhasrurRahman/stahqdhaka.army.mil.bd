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

                $mapping_id_special=[
                    'Ya'=>0,
                    'Is'=>1,
                    'Pa'=>2,
                    'Nq'=>3,
                    'MV'=>4,
                    'rD'=>5,
                    'QH'=>6,
                    'Lm'=>7,
                    'Nb'=>8,
                    'Ei'=>9
        ];
        $splited=str_split($id,2);
        //dd($id);
        $decryptedId='';
        foreach($splited as $key=>$value)
        {
            $decryptedId =$decryptedId.$mapping_id_special[$value];
        }
        $application = Application::find($decryptedId);

        return view('payment_gateway.payment_view', compact('application'));
    }

    public function payment_success($id)
    {
        $application = Application::find($id);

        return view('payment_gateway.payment_success',compact('application'));
    }

    public function allPaidRecollect()
    {
        return view('payment_gateway.payment_paid_recollect');
    }
}
