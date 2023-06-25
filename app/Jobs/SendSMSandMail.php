<?php

namespace App\Jobs;

use App\FollowUp;
use App\Http\Controllers\HomeController;
use App\Mail\notifyApproveMail;
use App\SmsApplicant; 
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSMSandMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $msg;
    private $phone;
    private $email;
    private $followupid;
    private $mail_status = '';
    private $sms_sent = '';
    private $sms;
    public function __construct($applicant_phone,$approveSms,$applicant_email,$followUp_Id,$sms)
    {
        $this->msg = $approveSms;
        $this->sms = $sms;
        $this->phone = $applicant_phone;
        $this->email = $applicant_email;
        $this->followupid = $followUp_Id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    { 
        $follow_up=FollowUp::find($this->followupid);
        // Mail::to($this->email)->send(new notifyApproveMail($this->msg));
        // if(Mail::failures()){
        //     $this->mail_status="fail";
        // }else{
        //     $this->mail_status="success";
        // }
    $res=HomeController::callSmsApi($this->phone,$this->msg);
        if ($res['status'] == 'SUCCESS' ){
          $sms_applicant = new SmsApplicant;
          $sms_applicant->application_id = $follow_up->application_id;
          $sms_applicant->sms_id = $this->sms->id;
          $sms_applicant->sms_status = $this->sms->type;
          $sms_applicant->api_CamID = $res['CamID'];
          $sms_applicant->save();
          $this->sms_sent = 'success';
      }else{
       $this->sms_sent = 'fail';
   }
   $follow_up->sms_sent=$this->sms_sent;
   $follow_up->mail_sent=$this->mail_status;
   $follow_up->update();
}
}
