<?php
namespace App\Http\Controllers; 
use App\Http\Controllers\HomeController; 
use App\Application;
use App\DriverInfo;
use App\VehicleInfo;
use App\VehicleOwner;
use App\OwnerInfo;
use App\User;
use App\Applicant;
use App\Sms; 
use App\Document;
use App\Jobs\VerifyAccount;

use App\SmsApplicant;
use Auth; 
use App\VehicleType;
use App\Rank;
use App\FollowUp;
use App\SpouseParentsUnit;
use App\Notifications\ApplicationNotification;
use App\ApplicantDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Redirect;
use App\Mail\ApplicationSubmissionConfirm;
use Mail;

class ApplicationController extends Controller
{ 
    
    public function verifyAccount(){
       
       $job = (new VerifyAccount($ApplicationNotify->applicant_phone,$final_approveSms,$app->applicant->email,$follow_up->id,$sms))
       ->onQueue($queue_status)->delay(Carbon::now()->addSeconds(0));
       dispatch($job); 
    }
 public function submissionSmsSend($id){
      
      $sms_sent='';   $mail_status='';
      
      $app=Application::findOrFail($id);
      $sms=Sms::where('type','=','submitted')->first();
      $bn= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
      $en= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

     $regNumber = str_replace($en, $bn, $app->vehicleinfo->reg_number);

      $final_subSms= str_replace('/reg/',$app->vehicleinfo->reg_number, $sms->sms_text);
      if(count(SmsApplicant::where('application_id',$id)->where('sms_id',$sms->id)->get())==0){
          
      
        if(strlen($app->applicant->phone)==11){ 
            
            $applicant_phone = '88'.$app->applicant->phone; }else{ 
            $applicant_phone = $app->applicant->phone; 
        }
        
        $mno=array();
        $mno[] = $applicant_phone;
        $message = $final_subSms;
        HomeController::callSmsApi($applicant_phone, $message);
      /*$url = 'http://panel.aamarsms.com/api/sendsms';
        $ch = curl_init($url);
        $jsonData = array(
        
        	'UserName' => 'stahqdhk',
        	'Password' => '@dmin210',
        	'MSISDN' => $mno,
        	'Message' => $message,
        	'Mask' => 'STA HQ DHK' 
        );
        
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        echo $result = curl_exec($ch);
        curl_close($ch);*/

      // dd($result);

      $follow_up = FollowUp::where('application_id', $id)->orderBy('id', 'desc')->first();
      $follow_up->sms_sent = 'success';
      $follow_up->mail_sent = 'success';
      $follow_up->comment = $final_subSms;
      $follow_up->save();
        
    // Mail::to($app->applicant->email)->send(new ApplicationSubmissionConfirm($final_subSms));
    // if (Mail::failures()){
        
    //    $mail_status="fail";
    // }else{
        
    //    $mail_status="success";
    // }
    //$dd = HomeController::callSmsApi($app->applicant->phone, $final_subSms);
    
        //dd($dd);
    
     // $sms_applicant = new SmsApplicant;
     // $sms_applicant->application_id = $app->id;
      //$sms_applicant->sms_id = $sms->id;
      //$sms_applicant->sms_status = $sms->type;
      //$sms_applicant->api_CamID = 1234;
      //$sms_applicant->save();
    
    $follow_up =FollowUp::where('application_id',$app->id)->where('status','Application requested')->where('updated_by',auth()->guard('applicant')->user()->name)->orderBy('created_at','desc')->first();
    $follow_up->sms_sent = 'success';
    $follow_up->mail_sent = 'success';
    $follow_up->comment = $final_subSms;
    $follow_up->save();
    
  }
}
 public function submissionSmsSendRenew($id){
  $sms_sent='';
  $mail_status='';
  $app=Application::findOrFail($id);
  $sms=Sms::where('type','=','submitted-renew')->first();
  $final_subSms= str_replace('/reg/', $app->vehicleinfo->reg_number, $sms->sms_text);
  if(count(SmsApplicant::where('application_id',$id)->where('sms_id',$sms->id)->get())==0)
  {
    Mail::to($app->applicant->email)->send(new ApplicationSubmissionConfirm($final_subSms));
    if (Mail::failures()){
      $mail_status="fail";
    }else{
      $mail_status="success";
    }
        $applicant_phone='';
        
        if(strlen($app->applicant->phone) == 11){ 
            
            $applicant_phone = '88'.$app->applicant->phone; }else{ 
            $applicant_phone = $app->applicant->phone;
        }
        
        $mno = array();
        
        $mno[0] = $applicant_phone;
        
        $message = $final_subSms;
        HomeController::callSmsApi($applicant_phone, $message);
        
        /*$url = 'http://panel.aamarsms.com/api/sendsms';
        $ch = curl_init($url);
        $jsonData = array(
        
        	'UserName' => 'stahqdhk',
        	'Password' => '@dmin210',
        	'MSISDN' => $mno,
        	'Message' => $message,
        	'Mask' => 'STA HQ DHK'    
        );
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        echo $result = curl_exec($ch);
        curl_close($ch); */
        
     
      $sms_applicant = new SmsApplicant;
      $sms_applicant->application_id = $app->id;
      $sms_applicant->sms_id = $sms->id;
      $sms_applicant->sms_status = $sms->type;
      $sms_applicant->api_CamID = 1235564534;
      $sms_applicant->save();
      //$sms_sent='success';
    //}else{
      //$sms_sent='fail'; 
    //}
    $sms_sent='success';
     
    $follow_up =FollowUp::where('application_id',$app->id)->where('status','Application requested')->where('updated_by',auth()->guard('applicant')->user()->name)->orderBy('created_at','desc')->first();
    $follow_up->sms_sent=$sms_sent;
    $follow_up->mail_sent=$mail_status;
    $follow_up->comment=$final_subSms;
    $follow_up->update();
  }
}

public function applicationFormStore(Request $request){
    $this->validate($request, [
      'applicant_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'applicant_nid_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'vehicle_reg_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'tax_token_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'fitness_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'road_permit_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'entry_pass_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'owner_nid_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'licence_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'org_id_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'school_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'job_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'auth_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'ward_com_cert' => 'nullable|image|mimes:jpg,jpeg,png',
      'house_owner_cert' => 'nullable|image|mimes:jpg,jpeg,png',
      'marriage_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'mother_testm_photo' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);
    // return $request->all();
 $exist_stickers = VehicleInfo::where('reg_number',$request->vehicle_reg_no)->get();
 $pending_count=0;
 $approve_count=0; 
 if(count($exist_stickers)>0){
  foreach($exist_stickers as $exist_sticker){
          // return $exist_sticker->application;
    if($exist_sticker->application->app_status =='pending' ){
     $pending_count++; 
   } 
   if($exist_sticker->application->app_status =='approved' ){
     $approve_count++;
   }

 }
}
if($pending_count==0 && $approve_count==0){
  DB::beginTransaction();
  try {

    if($request->applicant_name != auth()->guard('applicant')->user()->name || $request->applicant_phone != auth()->guard('applicant')->user()->phone ) {
      $applicant = Applicant::findOrFail(auth()->guard('applicant')->user()->id);
      $applicant->name = $request->applicant_name;
      $applicant->phone = $request->applicant_phone;
      $applicant->save();

    }
    if(empty(auth()->guard('applicant')->user()->applicantDetail)){
      $ApplicantDetail = new ApplicantDetail;
      if( $request->hasFile('applicant_photo') && $request->hasFile('applicant_nid_photo')){

        $applicant_photo_fileName = time() . '.' . $request->applicant_photo->getClientOriginalExtension();
        $applicant_photo_name = '/images/applicant_photo/'.$applicant_photo_fileName;
        $request->applicant_photo->move(public_path('images/applicant_photo'), $applicant_photo_name);
        $ApplicantDetail->applicant_photo = $applicant_photo_name;
        $applicant_nid_fileName = time() . '.' . $request->applicant_nid_photo->getClientOriginalExtension();
        $applicant_nid_name ='/images/applicant_nid/'.$applicant_nid_fileName;
        $request->applicant_nid_photo->move(public_path('images/applicant_nid'), $applicant_nid_name);
        $ApplicantDetail->nid_photo = $applicant_nid_name;
      }
      if($request->hasFile('applicant_Def_id_photo')){
        $applicant_defid_fileName = time() . '.' . $request->applicant_Def_id_photo->getClientOriginalExtension();
        $applicant_defid_name ='/images/applicant_def-id/'.$applicant_defid_fileName;
        $request->applicant_Def_id_photo->move(public_path('images/applicant_def-id'), $applicant_defid_name);
        $ApplicantDetail->defIdCopy = $applicant_defid_name;
      }
      $office_address = array(
        "o_flat" => $request->applicant_o_flat,
        "o_house" => $request->applicant_o_house,
        "o_road" => $request->applicant_o_road,
        "o_block" => $request->applicant_o_block,
        "o_area" => $request->applicant_o_area,
      );
      $present_address = array(
        "flat" => $request->applicant_flat,
        "house" => $request->applicant_house,
        "road" => $request->applicant_road,
        "block" => $request->applicant_block,
        "area" => $request->applicant_area,
      );
      $permanent_address = array(
        "p_flat" => $request->applicant_p_flat,
        "p_house" => $request->applicant_p_house,
        "p_road" => $request->applicant_p_road,
        "p_block" => $request->applicant_p_block,
        "p_area" => $request->applicant_p_area,
      );
      $applicant_address =array(
        "present" => $present_address,
        "permanent" => $permanent_address,
        "office" => $office_address,
      );
      if ($request->guardian == 1){
       $ApplicantDetail->father_name = $request->f_h_name;
     }
     else {
      $ApplicantDetail->husband_name = $request->f_h_name;
    }
    $ApplicantDetail->applicant_id =Auth::guard('applicant')->user()->id;
    $ApplicantDetail->address = json_encode($applicant_address);
    $ApplicantDetail->nid_number = $request->applicant_nid;
    $ApplicantDetail->profession = $request->profession;
    $ApplicantDetail->designation = $request->designation;
    $ApplicantDetail->company_name = $request->ap_company_name;
    if($request->applicant_spouse_Or_child!=''){
      $ApplicantDetail->is_spouseOrChild = true;
    }
    

    $ApplicantDetail->spouseOrParent_BA_no = $request->spouse_parent_BA_no;
    $ApplicantDetail->spouseOrParent_Name = $request->spouse_parent_name;
    $ApplicantDetail->spouseOrParent_Rank_id = $request->spouse_parents_rank;
    $ApplicantDetail->spouse_parents_units_id = $request->spouse_parents_unit;
    $ApplicantDetail->applicant_BA_no = $request->BA_no;
    $ApplicantDetail->rank_id = $request->applicant_rank;
    if($request->is_retired!=""){
     $ApplicantDetail->is_applicant_retired = true;
   }

   $ApplicantDetail->residence_type = $request->residence_type;
   $ApplicantDetail->tin = $request->applicant_tin;
   $ApplicantDetail->no_sticker_to_self_family = $request->sticker_num_to_self_family;
   $ApplicantDetail->allocated_current_sticker_type = $request->current_sticker_type;
   $ApplicantDetail->allocated_current_sticker_no = $request->current_sticker_no;
   $ApplicantDetail->applicant_remark = $request->applicant_remarks;
   $ApplicantDetail->save();
 }
 if(!empty(auth()->guard('applicant')->user()->applicantDetail)){

  $ApplicantDetail =ApplicantDetail::findOrFail(auth()->guard('applicant')->user()->applicantDetail->id);
  if( $request->hasFile('applicant_photo') ){
    \File::delete('images/applicant_photo/' . basename($ApplicantDetail->applicant_photo));
    $applicant_photo_fileName = time() . '.' . $request->applicant_photo->getClientOriginalExtension();
    $applicant_photo_name = '/images/applicant_photo/'.$applicant_photo_fileName;
    $request->applicant_photo->move(public_path('images/applicant_photo'), $applicant_photo_name);
    $ApplicantDetail->applicant_photo = $applicant_photo_name;
  }
  if($request->hasFile('applicant_nid_photo')){ 
    \File::delete('images/applicant_nid/' . basename($ApplicantDetail->nid_photo));
    $applicant_nid_fileName = time() . '.' . $request->applicant_nid_photo->getClientOriginalExtension();
    $applicant_nid_name ='/images/applicant_nid/'.$applicant_nid_fileName;
    $request->applicant_nid_photo->move(public_path('images/applicant_nid'), $applicant_nid_name);
    $ApplicantDetail->nid_photo = $applicant_nid_name;
  }
  if($request->hasFile('applicant_Def_id_photo')){
    \File::delete('images/applicant_def-id/' . basename($ApplicantDetail->defIdCopy));
    $applicant_defid_fileName = time() . '.' . $request->applicant_Def_id_photo->getClientOriginalExtension();
    $applicant_defid_name ='/images/applicant_def-id/'.$applicant_defid_fileName;
    $request->applicant_Def_id_photo->move(public_path('images/applicant_def-id'), $applicant_defid_name);
    $ApplicantDetail->defIdCopy = $applicant_defid_name;
  }


  $office_address = array(
    "o_flat" => $request->applicant_o_flat,
    "o_house" => $request->applicant_o_house,
    "o_road" => $request->applicant_o_road,
    "o_block" => $request->applicant_o_block,
    "o_area" => $request->applicant_o_area,
  );
  $present_address = array(
    "flat" => $request->applicant_flat,
    "house" => $request->applicant_house,
    "road" => $request->applicant_road,
    "block" => $request->applicant_block,
    "area" => $request->applicant_area,
  );
  $permanent_address = array(
    "p_flat" => $request->applicant_p_flat,
    "p_house" => $request->applicant_p_house,
    "p_road" => $request->applicant_p_road,
    "p_block" => $request->applicant_p_block,
    "p_area" => $request->applicant_p_area,
  );
  $applicant_address =array(
    "present" => $present_address,
    "permanent" => $permanent_address,
    "office" => $office_address,
  );
}
if ($request->guardian == 1){
  $ApplicantDetail->husband_name="";
  $ApplicantDetail->father_name = $request->f_h_name;
}
else {
  $ApplicantDetail->father_name="";
  $ApplicantDetail->husband_name = $request->f_h_name;
}
$ApplicantDetail->applicant_id =Auth::guard('applicant')->user()->id;
$ApplicantDetail->address = json_encode($applicant_address);
$ApplicantDetail->nid_number = $request->applicant_nid;
$ApplicantDetail->profession = $request->profession;
$ApplicantDetail->designation = $request->designation;
$ApplicantDetail->company_name = $request->ap_company_name;

if($request->applicant_spouse_Or_child !='' ){
  $ApplicantDetail->is_spouseOrChild = true;
  $ApplicantDetail->spouseOrParent_BA_no = $request->spouse_parent_BA_no;
  $ApplicantDetail->spouseOrParent_Name = $request->spouse_parent_name;
  $ApplicantDetail->spouseOrParent_Rank_id = $request->spouse_parents_rank;
  $ApplicantDetail->spouse_parents_units_id = $request->spouse_parents_unit;
  $ApplicantDetail->is_applicant_retired='';
  $ApplicantDetail->applicant_BA_no = '';
  $ApplicantDetail->rank_id = '';
}else{
  $ApplicantDetail->is_spouseOrChild = false;
  $ApplicantDetail->spouseOrParent_BA_no = '';
  $ApplicantDetail->spouseOrParent_Name = '';
  $ApplicantDetail->spouseOrParent_Rank_id = '';
  $ApplicantDetail->spouse_parents_units_id = '';
  $ApplicantDetail->applicant_BA_no = $request->BA_no;
  $ApplicantDetail->rank_id = $request->applicant_rank;
}

$ApplicantDetail->is_applicant_retired = $request->is_retired;
$ApplicantDetail->residence_type = $request->residence_type;
$ApplicantDetail->tin = $request->applicant_tin;
$ApplicantDetail->no_sticker_to_self_family = $request->sticker_num_to_self_family;
$ApplicantDetail->allocated_current_sticker_type = $request->current_sticker_type;
$ApplicantDetail->allocated_current_sticker_no = $request->current_sticker_no;
$ApplicantDetail->applicant_remark = $request->applicant_remarks;
$ApplicantDetail->update();


$application = new Application;
//            if($request->hasFile('app_photo')){
//              $applicationname = time() . '.' . $request->app_photo->getClientOriginalExtension();
//              $name = '/images/application/'.$applicationname;
//              $request->app_photo->move(public_path('images/application'), $name);
//          }
//           $application->app_photo = $name;
$application->app_number = (time()+rand(10,1000));
$application->applicant_id = Auth::guard('applicant')->user()->id;
// $application->sticker_category=$request->sticker_category;
$application->app_status="pending";
$application->app_date=Carbon::now();
$application->vehicle_type_id=$request->vehicle_type;
$application->type=Auth::guard('applicant')->user()->role;
if ($request->is_not_transparent=='1'){
 $application->glass_type=$request->glass_type;
}else{
  $application->glass_type='transparent';
}
$application->save();
if(!empty($request->renew_request) && $request->renew_request=='yes'){
 $old_app = Application::findOrFail($request->app_id);
 $old_app->renew = 'renew-applied';
 $old_app->save();
}

$VehicleInfo = new VehicleInfo;
$VehicleInfo->application_id=$application->id;
$VehicleInfo->app_number=$application->app_number;   
$VehicleInfo->insurance_validity=$request->insurance_validity;
$VehicleInfo->fitness_validity=$request->fitnness_validity;
$VehicleInfo->tax_token_validity=$request->tax_paid_upto;
$VehicleInfo->necessity_to_use=$request->necessity_to_use;
$VehicleInfo->reg_number=$request->vehicle_reg_no;
$VehicleInfo->vehicle_type_id=$request->vehicle_type;           
$VehicleInfo->loan_taken=$request->loan_taken;
if ($request->is_not_transparent=='1'){
 $VehicleInfo->glass_type=$request->glass_type;
}else{
  $VehicleInfo->glass_type='transparent';
}
$VehicleInfo->in_out_gate=$request->in_out_gate;
$VehicleInfo->in_out_time=$request->in_out_time;
if($request->hasFile('vehicle_reg_photo')){
  $vehicle_reg_filename = time() . '.' . $request->vehicle_reg_photo->getClientOriginalExtension();
  $vehicle_reg_name ='/images/vehicle_reg/'.$vehicle_reg_filename;
  $request->vehicle_reg_photo->move(public_path('images/vehicle_reg'), $vehicle_reg_name);
  $VehicleInfo->reg_cert_photo = $vehicle_reg_name;
}
if(!empty($request->renew_request) && $request->renew_request=='yes' && empty($request->hasFile('vehicle_reg_photo'))){
  $old_app = Application::findOrFail($request->app_id);
  $VehicleInfo->reg_cert_photo=$old_app->vehicleinfo->reg_cert_photo;  
}
if($request->hasFile('tax_token_photo')){
  $vehicle_tax_token_filename = time() . '.' . $request->tax_token_photo->getClientOriginalExtension();
  $vehicle_tax_token_name ='/images/vehicle_tax_token/'.$vehicle_tax_token_filename;
  $request->tax_token_photo->move(public_path('images/vehicle_tax_token'), $vehicle_tax_token_name);
  $VehicleInfo->tax_token_photo = $vehicle_tax_token_name;
}
if($request->hasFile('insurance_cert_photo')){
  $vehicle_insurance_filename = time() . '.' . $request->insurance_cert_photo->getClientOriginalExtension();
  $vehicle_insurance_name ='/images/vehicle_insurance/'.$vehicle_insurance_filename;
  $request->insurance_cert_photo->move(public_path('images/vehicle_insurance'), $vehicle_insurance_name);
  $VehicleInfo->insurance_cert_photo = $vehicle_insurance_name;
}
if($request->hasFile('fitness_cert_photo')){
  $vehicle_fitness_filename = time() . '.' . $request->fitness_cert_photo->getClientOriginalExtension();
  $vehicle_fitness_name = '/images/vehicle_fitness/'.$vehicle_fitness_filename;
  $request->fitness_cert_photo->move(public_path('images/vehicle_fitness'), $vehicle_fitness_name);
  $VehicleInfo->fitness_cert_photo = $vehicle_fitness_name;
}
if($request->hasFile('road_permit_photo')){          
  $road_permit_filename = time() . '.' . $request->road_permit_photo->getClientOriginalExtension();
  $road_permit_name = '/images/vehicle_road_permit/'.$road_permit_filename;
  $request->road_permit_photo->move(public_path('images/vehicle_road_permit'), $road_permit_name);
  $VehicleInfo->road_permit_photo = $road_permit_name;
}
if($request->hasFile('entry_pass_photo')){ 
  $vehicle_port_entry_pass_filename = time() . '.' . $request->entry_pass_photo->getClientOriginalExtension();
  $vehicle_port_entry_pass_name = '/images/vehicle_port_pass/'.$vehicle_port_entry_pass_filename;
  $request->entry_pass_photo->move(public_path('images/vehicle_port_pass'), $vehicle_port_entry_pass_name);
  $VehicleInfo->port_entry_pass_photo = $vehicle_port_entry_pass_name;
}
if($request->hasFile('jt_licence_photo')){
  $vehicle_jt_licence_copy_filename = time() . '.' . $request->jt_licence_photo->getClientOriginalExtension();
  $vehicle_jt_licence_copy_name = '/images/vehicle_jt_licence/'.$vehicle_jt_licence_copy_filename;
  $request->jt_licence_photo->move(public_path('images/vehicle_jt_licence'), $vehicle_jt_licence_copy_name);
  $VehicleInfo->jt_licence_photo = $vehicle_jt_licence_copy_name;
}
$VehicleInfo->save();



$VehicleOwner = new VehicleOwner;
$VehicleOwner->application_id=$application->id;
$VehicleOwner->nid_number=$request->owner_nid;
$VehicleOwner->app_number=$application->app_number; 
$present = array(
  "pre_flat" => $request->o_flat,
  "pre_house" => $request->o_house,
  "pre_road" => $request->o_road,
  "pre_block" => $request->o_block,
  "pre_area" => $request->o_area,
);
$permanent = array(
  "per_flat" => $request->o_per_flat,
  "per_house" => $request->o_per_house,
  "per_road" => $request->o_per_road,
  "per_block" => $request->o_per_block,
  "per_area" => $request->o_per_area,
);
$address = array(
  "present" => $present,
  "permanent" =>$permanent,
);
$com_address=array(
  "flat" => $request->c_flat,
  "house" => $request->c_house,
  "road" => $request->c_road,
  "block" => $request->c_block,
  "area" => $request->c_area, 
);
if($request->owner_is_company == "1"){
  $VehicleOwner->company_name= $request->company_name;
  $VehicleOwner->company_address=json_encode($com_address);
}
$VehicleOwner->owner_name= $request->owner_name;
$VehicleOwner->owner_address=json_encode($address);
if($request->hasFile('owner_nid_photo')){
  $vehicle_owner_nid_filename = time() . '.' . $request->owner_nid_photo->getClientOriginalExtension();
  $vehicle_owner_nid_name = '/images/vehicle_owner_nid/'.$vehicle_owner_nid_filename;
  $request->owner_nid_photo->move(public_path('images/vehicle_owner_nid'), $vehicle_owner_nid_name);
  $VehicleOwner->nid_photo = $vehicle_owner_nid_name;
}
if(!empty($request->renew_request) && $request->renew_request=='yes' && empty($request->hasFile('owner_nid_photo'))){

  $old_app = Application::findOrFail($request->app_id);
  $VehicleOwner->nid_photo=$old_app->vehicleowner->nid_photo;   
}
$VehicleOwner->save();

$DriverInfo = new DriverInfo;
$DriverInfo->application_id=$application->id;
$DriverInfo->app_number =$application->app_number;

if ($request->self_driven == '1')
{
  $DriverInfo->driver_is_owner = $request->self_driven;
  if($request->hasFile('licence_photo')){
   $driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
   $driver_licence_name ='/images/driver_licence/'.$driver_licence_filename;
   $request->licence_photo->move(public_path('images/driver_licence'),$driver_licence_name);
   $DriverInfo->licence_photo = $driver_licence_name;
 }
}
else{
  if($request->hasFile('licence_photo')){
    $driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
    $driver_licence_name ='/images/driver_licence/'.$driver_licence_filename;
    $request->licence_photo->move(public_path('images/driver_licence'),$driver_licence_name);
    $DriverInfo->licence_photo = $driver_licence_name;
  }
  $DriverInfo->name =$request->name;
  $DriverInfo->nid_number = $request->nid_number;
  $present_address = array(
    "flat" => $request->dri_pre_flat,
    "house" => $request->dri_pre_house,
    "road" => $request->dri_pre_road,
    "block" => $request->dri_pre_block,
    "area" => $request->dri_pre_area,
  );
  $permanent_address = array(
    "p_flat" => $request->dri_per_flat,
    "p_house" => $request->dri_per_house,
    "p_road" => $request->dri_per_road,
    "p_block" => $request->dri_per_block,
    "p_area" => $request->dri_per_area,
  );
  $driver_address =array(
    "present" => $present_address,
    "permanent" => $permanent_address,
  );

  $DriverInfo->address =json_encode($driver_address);
  if($request->hasFile('photo')){
    $driver_photo_fileName = time() . '.' . $request->photo->getClientOriginalExtension();
    $driver_photo_name = '/images/driver_photo/'.$driver_photo_fileName;
    $request->photo->move(public_path('images/driver_photo'), $driver_photo_name);
    $DriverInfo->photo = $driver_photo_name;               
  }            
  if($request->hasFile('nid_photo')){
    $driver_nid_fileName = time() . '.' . $request->nid_photo->getClientOriginalExtension();
    $driver_nid_name = '/images/driver_nid/'.$driver_nid_fileName;
    $request->nid_photo->move(public_path('images/driver_nid'), $driver_nid_name);
    $DriverInfo->nid_photo = $driver_nid_name;               
  }             

  if($request->hasFile('org_id_photo')){
    $driver_org_id_fileName = time() . '.' . $request->org_id_photo->getClientOriginalExtension();
    $driver_org_id_name ='/images/driver_org_id/'.$driver_org_id_fileName;
    $request->org_id_photo->move(public_path('images/driver_org_id'), $driver_org_id_name);
    $DriverInfo->org_id_photo = $driver_org_id_name;
  }
}
$DriverInfo->save();

$Document = new Document;
$Document->application_id = $application->id;
if($request->hasFile('school_cert_photo')){
  $school_cert_name = time() . '.' . $request->school_cert_photo->getClientOriginalExtension();
  $school_cert_file_name ='/images/school_cert/'.$school_cert_name;
  $request->school_cert_photo->move(public_path('images/school_cert'), $school_cert_file_name);
  $Document->school_cert = $school_cert_file_name;
}
if($request->hasFile('civil_service_photo')){
  $civil_service_id = time() . '.' . $request->civil_service_photo->getClientOriginalExtension();
  $civil_service_idFile ='/images/civil_service_id/'.$civil_service_id;
  $request->civil_service_photo->move(public_path('images/civil_service_id'), $civil_service_idFile);
  $Document->civil_service_id = $civil_service_idFile;
} 
if($request->hasFile('job_cert_photo')){
  $job_cert_name = time() . '.'  .  $request->job_cert_photo->getClientOriginalExtension();
  $job_cert_filename ='/images/job_cert_photo/'.$job_cert_name;
  $request->job_cert_photo->move(public_path('images/job_cert_photo'), $job_cert_filename);
  $Document->job_cert = $job_cert_filename;
}
if($request->hasFile('auth_cert_photo')){
  $auth_cert_name = time() . '.'  .  $request->auth_cert_photo->getClientOriginalExtension();
  $auth_cert_filename ='/images/auth_cert_photo/'.$auth_cert_name;
  $request->auth_cert_photo->move(public_path('images/auth_cert_photo'), $auth_cert_filename);
  $Document->auth_cert = $auth_cert_filename;
}
if($request->hasFile('ward_com_cert')){
  $ward_com_certname = time() . '.'  .  $request->ward_com_cert->getClientOriginalExtension();
  $ward_com_certnamefile ='/images/ward_com_cert/'.$ward_com_certname;
  $request->ward_com_cert->move(public_path('images/ward_com_cert'), $ward_com_certnamefile);
  $Document->ward_comm_cert = $ward_com_certnamefile;
}
if($request->hasFile('house_owner_cert')){
  $house_owner_certname = time() . '.'  .  $request->house_owner_cert->getClientOriginalExtension();
  $house_owner_certnamefile ='/images/house_owner_cert/'.$house_owner_certname;
  $request->house_owner_cert->move(public_path('images/house_owner_cert'), $house_owner_certnamefile);
  $Document->house_owner_cert = $house_owner_certnamefile;
}
if($request->hasFile('marriage_cert_photo')){
  $marriage_cert_photoname = time() . '.'  .  $request->marriage_cert_photo->getClientOriginalExtension();
  $marriage_cert_photonamefile ='/images/marriage_cert_photo/'.$marriage_cert_photoname;
  $request->marriage_cert_photo->move(public_path('images/marriage_cert_photo'), $marriage_cert_photonamefile);
  $Document->marriage_cert = $marriage_cert_photonamefile;
}
if($request->hasFile('father_testm_photo')){
  $father_testm_photoname = time() . '.'  .  $request->father_testm_photo->getClientOriginalExtension();
  $father_testm_photonamefile ='/images/father_testm_photo/'.$father_testm_photoname;
  $request->father_testm_photo->move(public_path('images/father_testm_photo'), $father_testm_photonamefile);
  $Document->father_testm = $father_testm_photonamefile;
}
if($request->hasFile('mother_testm_photo')){
  $mother_testm_photoname = time() . '.'  .  $request->mother_testm_photo->getClientOriginalExtension();
  $mother_testm_photonamefile ='/images/mother_testm_photo/'.$mother_testm_photoname;
  $request->mother_testm_photo->move(public_path('images/mother_testm_photo'), $mother_testm_photonamefile);
  $Document->mother_testm = $mother_testm_photonamefile;
}
$Document->save();

    // $follow_up=new FollowUp;
    // $follow_up->application_id=$application->id;
    // $follow_up->updater_role="customer";
    // $follow_up->status="pending";
    // $follow_up->created_date=Carbon::now();
    // $follow_up->updated_by=auth()->guard('applicant')->user()->name;
    // $follow_up->save();


// form all form cond end
DB::commit();

           // $sms=Sms::where('type','=','submitted')->first();
           //  $api = "6216f8a75fd5bb3d5f22b6f9958cdede3fc086c25b5";
           //  $sid  = "8801552146120";
           //  $contacts  = isset($applicant->phone)?$applicant->phone:auth()->guard('applicant')->user()->phone;
           //  $msg_body  =urlencode($sms->sms_text);
           //  $url  = "https://smsportal.pigeonhost.com/smsapi?api_key=$api&type=text&contacts=$contacts&senderid=$sid&msg=$msg_body";
           //  $xml  = file_get_contents($url);
           //  if (strpos($xml, "'type'=>'success'") !== false){
           //    $sms_applicant = new SmsApplicant;
           //    $sms_applicant->application_id =  $application->id;
           //    $sms_applicant->sms_id = $sms->id;
           //    $sms_applicant->sms_status = $sms->type;
           //    $sms_applicant->save();
           //  }
if(!empty($request->renew_request) && $request->renew_request=='yes'){
  $data ="Application Submitted Successfully for Renew!!";
}
else{
  $data ="New Application Submitted Successfully!!";
}
$renew_flag ="success renew";
return (array($data,$renew_flag));
}
catch (\Exception $e) {
  DB::rollback();
  $renew_flag ="DB_Transaction_error";
  $data ="Application Not Submitted. Please give accurate information.";
  return (array($data,$renew_flag));
}
}
else{
 $data ="You have already applied for this vehicle.";
 $renew_flag ="fail renew";
 return (array($data,$renew_flag));

}
}
public function applicationEditApplicant($appNumber){
  $vehicleTypes=VehicleType::orderBy('name','ASC')->get();
  $ranks=Rank::orderBy('name','ASC')->get();
  $units=SpouseParentsUnit::orderBy('name','ASC')->get();
  $app = Application::where('app_number', $appNumber)->first();

  // Solving Edit form when diff/ non-dif will be change;
  $applicant_role=Applicant::where('id',$app->applicant_id)->first()->role;
  
  if($app->app_status=="pending" || $app->app_status=="updated"){
   return view('forms.applicant-edit',compact('app','vehicleTypes','ranks','units','applicant_role'));
   
 }
 else{
   return Redirect::back()->withErrors(['You can only edit pending or rejected application. Thank You.']);

 } 
}
public function viewApplication($appNumber){
  $vehicleTypes=VehicleType::all();
  $ranks=Rank::all();
  $units=SpouseParentsUnit::all(); 
  $app = Application::where('app_number', $appNumber)->first();
  return view('layouts.applicant-app-review',compact('app'));
}
//Application Editing Function
public function applicationFormEdit(Request $request,$appid){
    $this->validate($request, [
      'applicant_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'applicant_nid_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'vehicle_reg_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'tax_token_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'fitness_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'road_permit_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'entry_pass_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'owner_nid_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'licence_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'org_id_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'school_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'job_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'auth_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'ward_com_cert' => 'nullable|image|mimes:jpg,jpeg,png',
      'house_owner_cert' => 'nullable|image|mimes:jpg,jpeg,png',
      'marriage_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
      'mother_testm_photo' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);
  $app_edit= Application::findOrFail($appid);
  DB::beginTransaction();
  try {
   $applicant = Applicant::findOrFail($app_edit->applicant->id);
   $applicant->name = $request->applicant_name;
   $applicant->phone = $request->applicant_phone;
   $applicant->save();

   $ApplicantDetail =ApplicantDetail::findOrFail($app_edit->applicant->applicantDetail->id);
   if( $request->hasFile('applicant_photo') ){
    \File::delete('images/applicant_photo/' . basename($ApplicantDetail->applicant_photo));
    $applicant_photo_fileName = time() . '.' . $request->applicant_photo->getClientOriginalExtension();
    $applicant_photo_name = '/images/applicant_photo/'.$applicant_photo_fileName;
    $request->applicant_photo->move(public_path('images/applicant_photo'), $applicant_photo_name);
    $ApplicantDetail->applicant_photo = $applicant_photo_name;
  }
  if($request->hasFile('applicant_nid_photo')){ 
    \File::delete('images/applicant_nid/' . basename($ApplicantDetail->nid_photo));
    $applicant_nid_fileName = time() . '.' . $request->applicant_nid_photo->getClientOriginalExtension();
    $applicant_nid_name ='/images/applicant_nid/'.$applicant_nid_fileName;
    $request->applicant_nid_photo->move(public_path('images/applicant_nid'), $applicant_nid_name);
    $ApplicantDetail->nid_photo = $applicant_nid_name;
  }
  if($request->hasFile('applicant_Def_id_photo')){
    \File::delete('images/applicant_def-id/' . basename($ApplicantDetail->defIdCopy));
    $applicant_defid_fileName = time() . '.' . $request->applicant_Def_id_photo->getClientOriginalExtension();
    $applicant_defid_name ='/images/applicant_def-id/'.$applicant_defid_fileName;
    $request->applicant_Def_id_photo->move(public_path('images/applicant_def-id'), $applicant_defid_name);
    $ApplicantDetail->defIdCopy = $applicant_defid_name;
  }
  $office_address = array(
    "o_flat" => $request->applicant_o_flat,
    "o_house" => $request->applicant_o_house,
    "o_road" => $request->applicant_o_road,
    "o_block" => $request->applicant_o_block,
    "o_area" => $request->applicant_o_area,
  );
  $present_address = array(
    "flat" => $request->applicant_flat,
    "house" => $request->applicant_house,
    "road" => $request->applicant_road,
    "block" => $request->applicant_block,
    "area" => $request->applicant_area,
  );
  $permanent_address = array(
    "p_flat" => $request->applicant_p_flat,
    "p_house" => $request->applicant_p_house,
    "p_road" => $request->applicant_p_road,
    "p_block" => $request->applicant_p_block,
    "p_area" => $request->applicant_p_area,
  );
  $applicant_address =array(
    "present" => $present_address,
    "permanent" => $permanent_address,
    "office" => $office_address,
  );
  if ($request->guardian == 1){
    $ApplicantDetail->husband_name="";
    $ApplicantDetail->father_name = $request->f_h_name;
  }
  else {
    $ApplicantDetail->father_name="";
    $ApplicantDetail->husband_name = $request->f_h_name;
  }
    // $ApplicantDetail->applicant_id =Auth::guard('applicant')->user()->id;
  $ApplicantDetail->address = json_encode($applicant_address);
  $ApplicantDetail->nid_number = $request->applicant_nid;
  $ApplicantDetail->profession = $request->profession;
  $ApplicantDetail->designation = $request->designation;
  $ApplicantDetail->company_name = $request->ap_company_name;

    // $ApplicantDetail->is_spouseOrChild = $request->applicant_spouse_Or_child;
  if($request->applicant_spouse_Or_child !='' ){
    $ApplicantDetail->is_spouseOrChild = true;
    $ApplicantDetail->spouseOrParent_BA_no = $request->spouse_parent_BA_no;
    $ApplicantDetail->spouseOrParent_Name = $request->spouse_parent_name;
    $ApplicantDetail->spouseOrParent_Rank_id = $request->spouse_parents_rank;
    $ApplicantDetail->spouse_parents_units_id = $request->spouse_parents_unit;
    $ApplicantDetail->is_applicant_retired =false;
    $ApplicantDetail->applicant_BA_no = null;
    $ApplicantDetail->rank_id = null;
  }else{
    $ApplicantDetail->is_spouseOrChild = false;
    $ApplicantDetail->spouseOrParent_BA_no = null;
    $ApplicantDetail->spouseOrParent_Name = null;
    $ApplicantDetail->spouseOrParent_Rank_id = null;
    $ApplicantDetail->spouse_parents_units_id = null;
    $ApplicantDetail->applicant_BA_no = $request->BA_no;
    $ApplicantDetail->rank_id = $request->applicant_rank;
    $ApplicantDetail->is_applicant_retired = $request->is_retired;
  }

  $ApplicantDetail->residence_type = $request->residence_type;
  $ApplicantDetail->tin = $request->applicant_tin;
  $ApplicantDetail->no_sticker_to_self_family = $request->sticker_num_to_self_family;
  $ApplicantDetail->allocated_current_sticker_type = $request->current_sticker_type;
  $ApplicantDetail->allocated_current_sticker_no = $request->current_sticker_no;
  $ApplicantDetail->applicant_remark = $request->applicant_remarks;
  $ApplicantDetail->save();


  $application=Application::findOrFail($appid);
  // $application->sticker_category=$request->sticker_category;
  $application->vehicle_type_id=$request->vehicle_type;
  if ($request->is_not_transparent=='1'){
   $application->glass_type=$request->glass_type;
 }else{
  $application->glass_type='transparent';
}
if(!empty(auth()->guard('applicant')->user()->name)){
  $application->app_status="pending";
}
$application->save();

$VehicleInfo =VehicleInfo::findOrFail($application->vehicleinfo->id);
$VehicleInfo->insurance_validity=$request->insurance_validity;
$VehicleInfo->fitness_validity=$request->fitnness_validity;
$VehicleInfo->tax_token_validity=$request->tax_paid_upto;
$VehicleInfo->necessity_to_use=$request->necessity_to_use;
$VehicleInfo->reg_number=$request->vehicle_reg_no;
$VehicleInfo->vehicle_type_id=$request->vehicle_type;
$VehicleInfo->loan_taken=$request->loan_taken;
if ($request->is_not_transparent=='1'){
 $VehicleInfo->glass_type=$request->glass_type;
}else{
  $VehicleInfo->glass_type='transparent';
}
$VehicleInfo->in_out_gate=$request->in_out_gate;
$VehicleInfo->in_out_time=$request->in_out_time;

if($request->hasFile('vehicle_reg_photo')){
  \File::delete('images/vehicle_reg/' . basename($VehicleInfo->reg_cert_photo));
  $vehicle_reg_filename = time() . '.' . $request->vehicle_reg_photo->getClientOriginalExtension();
  $vehicle_reg_name = '/images/vehicle_reg/' . $vehicle_reg_filename;
  $request->vehicle_reg_photo->move(public_path('images/vehicle_reg'), $vehicle_reg_name);
  $VehicleInfo->reg_cert_photo = $vehicle_reg_name;
}
if($request->hasFile('insurance_cert_photo')) {
  \File::delete('images/vehicle_insurance/' . basename($VehicleInfo->insurance_cert_photo));

  $vehicle_insurance_filename = time() . '.' . $request->insurance_cert_photo->getClientOriginalExtension();
  $vehicle_insurance_name = '/images/vehicle_insurance/' . $vehicle_insurance_filename;
  $request->insurance_cert_photo->move(public_path('images/vehicle_insurance'), $vehicle_insurance_name);
  $VehicleInfo->insurance_cert_photo = $vehicle_insurance_name;
}
if($request->hasFile('tax_token_photo')) {
  \File::delete('images/vehicle_tax_token/' . basename($VehicleInfo->tax_token_photo));

  $vehicle_tax_token_filename = time() . '.' . $request->tax_token_photo->getClientOriginalExtension();
  $vehicle_tax_token_name = '/images/vehicle_tax_token/' . $vehicle_tax_token_filename;
  $request->tax_token_photo->move(public_path('images/vehicle_tax_token'), $vehicle_tax_token_name);
  $VehicleInfo->tax_token_photo = $vehicle_tax_token_name;
}
if($request->hasFile('fitness_cert_photo')){
  \File::delete('images/vehicle_fitness/' . basename($VehicleInfo->fitness_cert_photo));

  $vehicle_fitness_filename = time() . '.' . $request->fitness_cert_photo->getClientOriginalExtension();
  $vehicle_fitness_name = '/images/vehicle_fitness/'.$vehicle_fitness_filename;
  $request->fitness_cert_photo->move(public_path('images/vehicle_fitness'), $vehicle_fitness_name);
  $VehicleInfo->fitness_cert_photo = $vehicle_fitness_name;
}
$VehicleInfo->save();

$VehicleOwner =VehicleOwner::findOrFail($application->vehicleowner->id);
$VehicleOwner->nid_number=$request->owner_nid;
$present = array(
  "pre_flat" => $request->o_flat,
  "pre_house" => $request->o_house,
  "pre_road" => $request->o_road,
  "pre_block" => $request->o_block,
  "pre_area" => $request->o_area,
);
$permanent = array(
  "per_flat" => $request->o_per_flat,
  "per_house" => $request->o_per_house,
  "per_road" => $request->o_per_road,
  "per_block" => $request->o_per_block,
  "per_area" => $request->o_per_area,
);
$address = array(
  "present" => $present,
  "permanent" =>$permanent,
);
$com_address=array(
  "flat" => $request->c_flat,
  "house" => $request->c_house,
  "road" => $request->c_road,
  "block" => $request->c_block,
  "area" => $request->c_area,
);
if($request->owner_is_company == "1"){
  $VehicleOwner->company_name= $request->company_name;
  $VehicleOwner->company_address=json_encode($com_address);
}else{
  $VehicleOwner->company_name= '';
  $VehicleOwner->company_address=null;
}
$VehicleOwner->owner_name= $request->owner_name;
$VehicleOwner->owner_address=json_encode($address);
if($request->hasFile('owner_nid_photo')){
  \File::delete('images/vehicle_owner_nid/' . basename($VehicleOwner->nid_photo));

  $vehicle_owner_nid_filename = time() . '.' . $request->owner_nid_photo->getClientOriginalExtension();
  $vehicle_owner_nid_name = '/images/vehicle_owner_nid/'.$vehicle_owner_nid_filename;
  $request->owner_nid_photo->move(public_path('images/vehicle_owner_nid'), $vehicle_owner_nid_name);
  $VehicleOwner->nid_photo = $vehicle_owner_nid_name;
}
$VehicleOwner->save();


$DriverInfo = DriverInfo::findOrFail($application->driverinfo->id);
if( $request->self_driven == '1'){
  if($DriverInfo->driver_is_owner!='1'){
    \File::delete('images/driver_nid/' . basename($DriverInfo->nid_photo));
    $DriverInfo->nid_photo='';
    \File::delete('images/driver_photo/' . basename($DriverInfo->photo));
    $DriverInfo->photo='';
    if($request->hasFile('licence_photo')) {
      \File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));

      $driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
      $driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
      $request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
      $DriverInfo->licence_photo = $driver_licence_name;
    }
    $DriverInfo->name ='';
    $DriverInfo->nid_number =null;
    $DriverInfo->address ='';
    $DriverInfo->driver_is_owner='1';
    $DriverInfo->save();
  }else{
    if($request->hasFile('licence_photo')) {
      \File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));
      $driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
      $driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
      $request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
      $DriverInfo->licence_photo = $driver_licence_name;
    }
    $DriverInfo->save();
  }
}
if($request->self_driven != '1'){
 if($DriverInfo->driver_is_owner=='1'){
  $DriverInfo->driver_is_owner=null;
}
if($request->hasFile('licence_photo')) {
  \File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));
  $driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
  $driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
  $request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
  $DriverInfo->licence_photo = $driver_licence_name;
}
$DriverInfo->name =$request->name;
$DriverInfo->nid_number = $request->nid_number;
$present_address = array(
  "flat" => $request->dri_pre_flat,
  "house" => $request->dri_pre_house,
  "road" => $request->dri_pre_road,
  "block" => $request->dri_pre_block,
  "area" => $request->dri_pre_area,
);
$permanent_address = array(
  "p_flat" => $request->dri_per_flat,
  "p_house" => $request->dri_per_house,
  "p_road" => $request->dri_per_road,
  "p_block" => $request->dri_per_block,
  "p_area" => $request->dri_per_area,
);
$driver_address =array(
  "present" => $present_address,
  "permanent" => $permanent_address,
);
$DriverInfo->address =json_encode($driver_address);
if( $request->hasFile('nid_photo')){
  \File::delete('images/driver_nid/' . basename($DriverInfo->nid_photo));

  $driver_nid_fileName = time() . '.' . $request->nid_photo->getClientOriginalExtension();
  $driver_nid_name = '/images/driver_nid/' . $driver_nid_fileName;
  $request->nid_photo->move(public_path('images/driver_nid'), $driver_nid_name);
  $DriverInfo->nid_photo = $driver_nid_name;
}
if($request->hasFile('photo')) {
  \File::delete('images/driver_photo/' . basename($DriverInfo->photo));

  $driver_photo_fileName = time() . '.' . $request->photo->getClientOriginalExtension();
  $driver_photo_name = '/images/driver_photo/' . $driver_photo_fileName;
  $request->photo->move(public_path('images/driver_photo'), $driver_photo_name);
  $DriverInfo->photo = $driver_photo_name;
}
$DriverInfo->save();
}
$Document = Document::findOrFail($application->document->id);
if($request->hasFile('school_cert_photo')){
  \File::delete('images/school_cert/' . basename($DriverInfo->school_cert));
  $school_cert_name = time() . '.' . $request->school_cert_photo->getClientOriginalExtension();
  $school_cert_file_name ='/images/school_cert/'.$school_cert_name;
  $request->school_cert_photo->move(public_path('images/school_cert'), $school_cert_file_name);
  $Document->school_cert = $school_cert_file_name;
}
if($request->hasFile('civil_service_photo')){
  \File::delete('images/civil_service_id/' . basename($DriverInfo->civil_service_id));
  $civil_service_id = time() . '.' . $request->civil_service_photo->getClientOriginalExtension();
  $civil_service_idFile ='/images/civil_service_id/'.$civil_service_id;
  $request->civil_service_photo->move(public_path('images/civil_service_id'), $civil_service_idFile);
  $Document->civil_service_id = $civil_service_idFile;
} 
if($request->hasFile('job_cert_photo')){
  \File::delete('images/job_cert_photo/' . basename($DriverInfo->job_cert));
  $job_cert_name = time() . '.'  .  $request->job_cert_photo->getClientOriginalExtension();
  $job_cert_filename ='/images/job_cert_photo/'.$job_cert_name;
  $request->job_cert_photo->move(public_path('images/job_cert_photo'), $job_cert_filename);
  $Document->job_cert = $job_cert_filename;
}
if($request->hasFile('auth_cert_photo')){
  \File::delete('images/auth_cert_photo/' . basename($DriverInfo->auth_cert));
  $auth_cert_name = time() . '.'  .  $request->auth_cert_photo->getClientOriginalExtension();
  $auth_cert_filename ='/images/auth_cert_photo/'.$auth_cert_name;
  $request->auth_cert_photo->move(public_path('images/auth_cert_photo'), $auth_cert_filename);
  $Document->auth_cert = $auth_cert_filename;
}
if($request->hasFile('ward_com_cert')){
  \File::delete('images/ward_com_cert/' . basename($DriverInfo->ward_comm_cert));
  $ward_com_certname = time() . '.'  .  $request->ward_com_cert->getClientOriginalExtension();
  $ward_com_certnamefile ='/images/ward_com_cert/'.$ward_com_certname;
  $request->ward_com_cert->move(public_path('images/ward_com_cert'), $ward_com_certnamefile);
  $Document->ward_comm_cert = $ward_com_certnamefile;
}
if($request->hasFile('house_owner_cert')){
  \File::delete('images/house_owner_cert/' . basename($DriverInfo->house_owner_cert));
  $house_owner_certname = time() . '.'  .  $request->house_owner_cert->getClientOriginalExtension();
  $house_owner_certnamefile ='/images/house_owner_cert/'.$house_owner_certname;
  $request->house_owner_cert->move(public_path('images/house_owner_cert'), $house_owner_certnamefile);
  $Document->house_owner_cert = $house_owner_certnamefile;
}
if($request->hasFile('marriage_cert_photo')){
  \File::delete('images/marriage_cert_photo/' . basename($DriverInfo->marriage_cert));
  $marriage_cert_photoname = time() . '.'  .  $request->marriage_cert_photo->getClientOriginalExtension();
  $marriage_cert_photonamefile ='/images/marriage_cert_photo/'.$marriage_cert_photoname;
  $request->marriage_cert_photo->move(public_path('images/marriage_cert_photo'), $marriage_cert_photonamefile);
  $Document->marriage_cert = $marriage_cert_photonamefile;
}
if($request->hasFile('father_testm_photo')){
 \File::delete('images/father_testm_photo/' . basename($DriverInfo->father_testm));
 $father_testm_photoname = time() . '.'  .  $request->father_testm_photo->getClientOriginalExtension();
 $father_testm_photonamefile ='/images/father_testm_photo/'.$father_testm_photoname;
 $request->father_testm_photo->move(public_path('images/father_testm_photo'), $father_testm_photonamefile);
 $Document->father_testm = $father_testm_photonamefile;
}
if($request->hasFile('mother_testm_photo')){
 \File::delete('images/mother_testm_photo/' . basename($DriverInfo->mother_testm));
 $mother_testm_photoname = time() . '.'  .  $request->mother_testm_photo->getClientOriginalExtension();
 $mother_testm_photonamefile ='/images/mother_testm_photo/'.$mother_testm_photoname;
 $request->mother_testm_photo->move(public_path('images/mother_testm_photo'), $mother_testm_photonamefile);
 $Document->mother_testm = $mother_testm_photonamefile;
}
$Document->save();
$follow_up=new FollowUp;
$follow_up->application_id=$app_edit->id;
$follow_up->updater_role='customer';
$follow_up->status="pending";
$follow_up->created_date=Carbon::now();
$follow_up->updated_by=!empty(auth()->guard('applicant')->user()->name)?auth()->guard('applicant')->user()->name:auth()->user()->name;
$follow_up->save();   
DB::commit();
$users= User::all();
foreach ($users as $user) {
  if(isset($applicant->name) && $applicant->name!=''){
    $app_dtail = array(
      "app_number" => $application->app_number,
      "applicant_name" => $applicant->name,
    );
    $user->notify(new ApplicationNotification($app_dtail));
  } 
  elseif(!empty(auth()->user()->name)){
   $app_dtail = array(
    "app_number" => $application->app_number,
    "applicant_name" =>auth()->user()->name,
  );
   $user->notify(new ApplicationNotification($app_dtail));
 }
}
$data ="Application Updated successfully!";
$renew_flag ="success renew";
$userType="";
if(isset(auth()->guard('applicant')->user()->name)){
  $userType="Customer";
}
return (array($data,$renew_flag,$userType));
}
catch (\Exception $e) {
  DB::rollback();
  $renew_flag ="DB_Transaction_error";
  $data ="Application Not Updated. Please give accurate information.";
  return (array($data,$renew_flag));
}   
}
}


