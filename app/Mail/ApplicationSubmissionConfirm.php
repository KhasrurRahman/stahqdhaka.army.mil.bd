<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationSubmissionConfirm extends Mailable
{
    use Queueable, SerializesModels;

    /** 
     * Create a new message instance.
     *
     * @return void
     */
    private $msg;
    public function __construct($msg)
    {
         $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.Application_Submission_Confirm')->with('msg',$this->msg);
    }
}
