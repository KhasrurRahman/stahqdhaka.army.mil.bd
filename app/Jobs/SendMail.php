<?php

namespace App\Jobs;

use App\FollowUp;
use App\Mail\NotifyApplicant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */ 
    private $msg;
    private $email;
    private $followupid;
    private $mail_status = '';
    public function __construct($applicant_email,$msg,$followUp_Id)
    {

        $this->msg = $msg;
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
        Mail::to($this->email)->send(new NotifyApplicant($this->msg));
        if(Mail::failures()){
            $this->mail_status="fail";
        }else{
            $this->mail_status="success";
        }
        $follow_up->mail_sent=$this->mail_status;
        $follow_up->update();
    }
}
