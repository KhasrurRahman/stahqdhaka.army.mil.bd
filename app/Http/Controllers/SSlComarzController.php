<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Application;
use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SSlComarzController extends Controller
{
    public function make_payment(Request $request)
    {
        $applicantion = Application::find($request->application_id);
        // $data = json_decode($request->cart_json, true);
        $post_data = [];
        $post_data['total_amount'] = $request->amount;
        $post_data['currency'] = 'BDT';
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $applicantion->applicant->name;
        $post_data['cus_email'] = $applicantion->applicant->email ? $applicantion->applicant->email : 'softdev2@tilbd.net';
        $post_data['cus_add1'] = '';
        $post_data['cus_add2'] = '';
        $post_data['cus_city'] = '';
        $post_data['cus_state'] = '';
        $post_data['cus_postcode'] = '';
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = $applicantion->applicant->phone;
        $post_data['cus_fax'] = '';

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = 'Store Test';
        $post_data['ship_add1'] = 'Dhaka';
        $post_data['ship_add2'] = 'Dhaka';
        $post_data['ship_city'] = 'Dhaka';
        $post_data['ship_state'] = 'Dhaka';
        $post_data['ship_postcode'] = '1000';
        $post_data['ship_phone'] = '';
        $post_data['ship_country'] = 'Bangladesh';

        $post_data['shipping_method'] = 'NO';
        $post_data['product_name'] = 'Computer';
        $post_data['product_category'] = 'Goods';
        $post_data['product_profile'] = 'physical-goods';

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $applicantion->id;
        $post_data['value_b'] = $applicantion->applicant->id;
        $post_data['value_c'] = '';

        $values = [
            'application_id' => $applicantion->id,
            'name' => $post_data['cus_name'],
            'email' => $post_data['cus_email'],
            'amount' => $post_data['total_amount'],
            'phone' => $post_data['cus_phone'],
            'status' => 0,
            'address' => $post_data['cus_add1'],
            'transaction_id' => $post_data['tran_id'],
            'payment_by' => 'SSL',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('ssl_payments')->insert($values);
        $sslc = new SslCommerzNotification();

        $payment_options = $sslc->makePayment($post_data, 'hosted');
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = [];
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $sslc = new SslCommerzNotification();
        $order_detials = DB::table('ssl_payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')
            ->first();

        if ($order_detials->status == 0) {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == true) {
                DB::table('ssl_payments')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 1]);
                $this->complete_payment($request->value_a,$amount);
                Session::flash('message', 'Transaction is successfully Completed');
                return redirect()->route('payment_success',$request->value_a);
            } else {
                DB::table('ssl_payments')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 3]);
                Session::flash('alert', 'validation Fail');
                return redirect()->route('payment.view', encrypt($request->value_a));
            }
        } elseif ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 1]);
            $this->complete_payment($request->value_a,$amount);
            Session::flash('message', 'Transaction is successfully Completed');
            return redirect()->route('payment_success',$request->value_a);
        } else {
            DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 3]);
            Session::flash('message', 'Transaction is successfully Completed');
            return redirect()->route('payment_success');
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('ssl_payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')
            ->first();
        if ($order_detials->status == 0) {
            $update_product = DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 3]);
            Session::flash('alert', 'Transaction is Falied');
            return redirect()->route('payment.view', encrypt($request->value_a));
        } elseif ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            Session::flash('message', 'Transaction is already Completed');
            return redirect()->route('payment.view', encrypt($request->value_a));
        } else {
            Session::flash('alert', 'Invalid Transaction');
            return redirect()->route('payment.view', encrypt($request->value_a));
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('ssl_payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')
            ->first();

        if ($order_detials->status == 0) {
            $update_product = DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 2]);
            Session::flash('alert', 'Transaction is Cancel');
            return redirect()->route('payment.view', encrypt($request->value_a));
        } elseif ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            Session::flash('message', 'Transaction is already Completed');
            return redirect()->route('payment.view', encrypt($request->value_a));
        } else {
            Session::flash('alert', 'Invalid Transaction');
            return redirect()->route('payment.view', encrypt($request->value_a));
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) {
            #Check transation id is posted or not.
            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('ssl_payments')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')
                ->first();

            if ($order_details->status == 0) {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == true) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $this->Establish_connection($request->value_b, $request->value_a, $request->value_c, $order_details->amount);
                    $update_product = DB::table('ssl_payments')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 1]);

                    echo 'Transaction is successfully Completed';
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('ssl_payments')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 3]);

                    echo 'validation Fail';
                }
            } elseif ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                #That means Order status already updated. No need to udate database.

                echo 'Transaction is already successfully Completed';
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo 'Invalid Transaction';
            }
        } else {
            echo 'Invalid Data';
        }
    }

    private function complete_payment($application_id, $amount)
    {
        $application = Application::find($application_id);
        $application->payment_status = 1;
        $application->app_status = 'paid';
        $application->update();

        $now = date('Y-m-d H:i:s');
        $debit = 0;
        $credit = $amount;
        $balance = 0;

        // credit add into into payment table
        $payment_values = [
            'application_id' => $application->id,
            'type' => 'SSL',
            'comment' => 'By online',
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $balance,
            'created_at' => $now,
            'created_by' => $application->applicant->id,
            'created_user_type' => 'subscriber',
        ];
        DB::table('payments')->insert($payment_values);
    }
}
