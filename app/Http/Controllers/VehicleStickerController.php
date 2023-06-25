<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehicleSticker;
use Carbon\Carbon;
use Redirect;
use App\Rank;
class VehicleStickerController extends Controller
{
 public function renewRequest($id){
    	 $allocated_sticker=VehicleSticker::find($id);
    	 $old_application_id = $allocated_sticker->application_id;
    	 $now = Carbon::now()->addDays(16)->toDateString();
        $ranks = Rank::orderBy('name','ASC')->get();
    	 if($now >=$allocated_sticker->exp_date){
 			return view('layouts.renew',compact('allocated_sticker','old_application_id','ranks'));
 		}
 		else{
 			return redirect('/customer/home');

 		}
	}

	public function renewSMS(Request $request)
	{
	
		$total_renew = VehicleSticker::where('exp_date', '2022-12-31')->where('sms_exp_msg_isSent', 0)->count();
		return view('renew_sms', compact('total_renew'));
	}

    public function sendRenewSMS(Request $request)
    {

        $skip = $request->skip;
        $quantity = $request->quantity;
        $total = $skip+ $quantity;
        $stickers = VehicleSticker::where('exp_date', '2022-12-31')
            ->where('sms_exp_msg_isSent', 0)
            ->orderBy('id','asc')
//		->skip($skip)
//		->take($quantity)
            ->get();


        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");


        $messages=null;

        foreach ($stickers as $key => $sticker) {

            if (strlen($sticker->applicant->phone) == 11) {
                $applicant_phone = '88' . $sticker->applicant->phone;
            } else {
                $applicant_phone = $sticker->applicant->phone;
            }
            $issue_date = str_replace($en, $bn, date('d-m-Y', strtotime($sticker->issue_date)));
            $exp_date = str_replace($en, $bn, date('d-m-Y', strtotime($sticker->exp_date)));
            $message = "অভিনন্দন! আপনার যানবাহনের অনূকুলে (".$sticker->reg_number.") ".$issue_date." তারিখে স্টিকার বরাদ্দ দেওয়া হয়েছে। স্টিকারটির মেয়াদ উর্ত্তীনের তারিখ ".$exp_date."। আপনার আবেদনটি পুনরায় হালনাগাদ করুন। স্টেশন সদর দপ্তর, ঢাকা সেনানিবাস।";

           $messages[]=array("to"=>$applicant_phone,'message'=>$message);



           VehicleSticker::where('id', $sticker->id)->update(['sms_exp_msg_isSent' => 1]);

        }

        return HomeController::callSmsApi(null, $messages,1);

        $msg = "Skip user = ".$skip." Send renew sms = ". $quantity." Total send = ". $total;
       // return redirect()->back()->with('success', HomeController::callSmsApi($applicant_phone, $messages,1));
    }
}
