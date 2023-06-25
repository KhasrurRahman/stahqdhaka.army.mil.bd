<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sms;
use App\FollowUp;
use App\SmsApplicant;
use App\Http\Controllers\HomeController;
use Auth;
class SmsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function smsPanel(){
    $all_sms=Sms::where('type','manual')->get();
    return view('layouts.sms-panel',compact('all_sms'));
  }
  public function retrySendSms($id){
    $follow_up=FollowUp::findOrFail($id);
    $smsType='';
    $sms_sent='';
    if($follow_up->app_status=='pending'){
     $smsType='submitted';
   }
   if($follow_up->app_status=='approved'){
     $smsType='approved';
   }
   if($follow_up->app_status=='rejected'){
     $smsType='rejected';
   }
   $sms = SMS::where('type',$smsType)->first();
   $res = HomeController::callSmsApi($follow_up->application->applicant->phone , $follow_up->comment);
    
    $sms_applicant = new SmsApplicant;
    $sms_applicant->application_id =  $follow_up->application_id;
    $sms_applicant->sms_id =$sms->id;
    $sms_applicant->sms_status = $sms->type;
    $sms_applicant->api_CamID = 12357856;
    $sms_applicant->save();
    $sms_sent='success';
    $follow_up->sms_sent=$sms_sent;
    $follow_up->update();
   
  return array($sms_sent);
} 
public function smsAdd(Request $req){
 $this->validate($req,[
  'sms_template_name' => 'required|unique:sms',
  'sms_subject' => 'required|min:4',
  'sms_text' => 'required|min:4'
]);
 $sms = new Sms; 
 $sms->sms_template_name=$req->sms_template_name;
 $sms->sms_subject=$req->sms_subject;
 $sms->type='manual';
 $sms->sms_text=$req->sms_text;
 $sms->creator=auth()->user()->name;
 $sms->updater='';
 $sms->save();	
 $data ="SMS has been added successfully.";
 return array($data,$sms);
} 
public function smsUpdate(Request $req,$id){
  $sms =Sms::findOrFail($id);
  if($sms->sms_template_name!=$req->sms_template_name){
    $sms->sms_template_name=$req->sms_template_name;
  }
  $sms->sms_subject=$req->sms_subject;
  $sms->sms_text=$req->sms_text;
  $sms->updater=Auth::user()->name;
  $sms->update(); 
  $data ="SMS has been updated successfully.";
  return array($data,$sms);
}   
public function smsDelete(Request $req){
  $sms =Sms::findOrFail($req->id);
  $sms->delete(); 
  $data ="SMS has been deleted successfully!";
  return array($data);
}
public function sendQueueSms($queue_status){
  \Artisan::call('queue:work',['database','--once'=>'--once','--queue'=>$queue_status,'--tries'=>1]);
}
}
