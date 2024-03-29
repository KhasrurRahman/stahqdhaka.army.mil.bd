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
		$types=$request->type;
		$expdate=$request->expdate;
		$typesArray=explode(',',$request->type);	
		$total_renew = VehicleSticker::where('exp_date', $request->expdate)->where('sms_exp_msg_isSent', 0)->whereIn('sticker_value',$typesArray)->count();
		return view('renew_sms', compact('total_renew','types','expdate'));
	}

    public function sendRenewSMS(Request $request)
    {

        $skip = $request->skip;
        $quantity = $request->quantity;
        $total = $skip+ $quantity;
	$types=explode(',',$request->types);
	$expdate=$request->expdate;
        $stickers = VehicleSticker::where('exp_date', $expdate)
            ->where('sms_exp_msg_isSent', 0)
	->whereIn('sticker_value',$types)
            ->orderBy('id','asc')
	->skip($skip)
	->take($quantity)
            ->get();


        $bn = array("à§§", "à§¨", "à§©", "à§ª", "à§«", "à§¬", "à§­", "à§®", "à§¯", "à§¦");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");


        $messages=null;

        foreach ($stickers as $key => $sticker) {

            if (strlen($sticker->applicant->phone) == 11) {
                $applicant_phone = '88' . $sticker->applicant->phone;
		//$applicant_phone='8801814826919';
            } else {
                $applicant_phone = $sticker->applicant->phone;
            }
            $issue_date = str_replace($en, $bn, date('d-m-Y', strtotime($sticker->issue_date)));
            $exp_date = str_replace($en, $bn, date('d-m-Y', strtotime($sticker->exp_date)));
           // $message = "à¦…à¦­à¦¿à¦¨à¦¨à§à¦¦à¦¨! à¦†à¦ªà¦¨à¦¾à¦° à¦¯à¦¾à¦¨à¦¬à¦¾à¦¹à¦¨à§‡à¦° à¦…à¦¨à§‚à¦•à§à¦²à§‡ (".$sticker->reg_number.") ".$issue_date." à¦¤à¦¾à¦°à¦¿à¦–à§‡ à¦¸à§à¦Ÿà¦¿à¦•à¦¾à¦° à¦¬à¦°à¦¾à¦¦à§à¦¦ à¦¦à§‡à¦“à§Ÿà¦¾ à¦¹à§Ÿà§‡à¦›à§‡à¥¤ à¦¸à§à¦Ÿà¦¿à¦•à¦¾à¦°à¦Ÿà¦¿à¦° à¦®à§‡à§Ÿà¦¾à¦¦ à¦‰à¦°à§à¦¤à§à¦¤à§€à¦¨à§‡à¦° à¦¤à¦¾à¦°à¦¿à¦– ".$exp_date."à¥¤ à¦†à¦ªà¦¨à¦¾à¦° à¦†à¦¬à§‡à¦¦à¦¨à¦Ÿà¦¿ à¦ªà§à¦¨à¦°à¦¾à§Ÿ à¦¹à¦¾à¦²à¦¨à¦¾à¦—à¦¾à¦¦ à¦•à¦°à§à¦¨à¥¤ à¦¸à§à¦Ÿà§‡à¦¶à¦¨ à¦¸à¦¦à¦° à¦¦à¦ªà§à¦¤à¦°, à¦¢à¦¾à¦•à¦¾ à¦¸à§‡à¦¨à¦¾à¦¨à¦¿à¦¬à¦¾à¦¸à¥¤";
           $message = "আপনার যানবাহনের (" . $sticker->reg_number . ") স্টিকারটির মেয়াদ ৩১-১২-২০২৩ তারিখে উত্তীর্ণ হবে। নতুন স্টিকারের জন্য পুনরায় অনলাইনে (stahqdhaka.army.mil.bd) তথ্য হালনাগাদ করুন। স্টেশন সদর দপ্তর,  ঢাকা সেনানিবাস।";

           $messages[]=array("to"=>$applicant_phone,'message'=>$message);



	           VehicleSticker::where('id', $sticker->id)->update(['sms_exp_msg_isSent' => 1]);
	//HomeController::callSmsApi(null,$messages,1);
		//die('Done');

        }

        return HomeController::callSmsApi(null, $messages,1);

        $msg = "Skip user = ".$skip." Send renew sms = ". $quantity." Total send = ". $total;
       // return redirect()->back()->with('success', HomeController::callSmsApi($applicant_phone, $messages,1));
    }
}