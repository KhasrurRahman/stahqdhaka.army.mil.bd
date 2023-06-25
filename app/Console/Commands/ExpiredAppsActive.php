<?php

namespace App\Console\Commands;
use App\Http\Controllers\HomeController;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\VehicleSticker;
use App\Application;
use App\Sms;
use App\SmsApplicant;
use App\FollowUp;
use DB;
use Mail;
use App\Mail\notifyExpiredMail;
use App\Mail\notifyWarningMail;
class ExpiredAppsActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ExpiredAppsActive:expireStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do Issued status to Expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mail_status='';
        $mytime =Carbon::now()->toDateString();
        $fifteen_days = Carbon::now()->addDays(16)->toDateString();

        $stickers=VehicleSticker::all();
        $excludeCategories = ['F', 'T', 'T1'];

        foreach ($stickers as $key => $sticker) {
          if($fifteen_days == $sticker->exp_date && $sticker->sms_exp_warn=='' && $sticker->sms_exp_expired=='' && !in_array($sticker->sticker_value, $excludeCategories)){
            $app = Application::findOrFail($sticker->application->id);
            $app->app_status = "warning";
            $app->renew="renew-warned";
            $app->save();
            $stick=VehicleSticker::findOrFail($sticker->id);
            $stick->sms_exp_warn="warned";
            $stick->sms_exp_expired="will be expired";
            $stick->save();
            $sms=Sms::where('type', 'warning')->first();
            $sms_add_reg=str_replace('/reg/',$sticker->reg_number, $sms->sms_text); 
            $sms_final=str_replace('/date/',$sticker->exp_date, $sms_add_reg);
            /*Mail::to($app->applicant->email)->send(new notifyWarningMail($sms_final));
            if (Mail::failures()){
              $mail_status="fail";
            }else{
              $mail_status="success";
            }*/

            HomeController::callSmsApi($sticker->applicant->phone, $sms_final);

          /*$post_url = 'http://smsportal.pigeonhost.com/smsapi' ;
          $post_values = array( 
            'api_key' => '3717862a00f88c6164a735d661d4e9c91c5d976779d0f7f488e3bbd945638118d222c6a8',
                'type' => 'text',  // unicode or text
                'senderid' => '8804445641111',
                'contacts' => $sticker->applicant->phone,
                'msg' => $sms_final,
                'method' => 'api'
            );
          $post_string = "";
          foreach( $post_values as $key => $value )
          { 
            $post_string .= "$key=" . urlencode( $value ) . "&"; 
        }
        $post_string = rtrim( $post_string, "& " );
        $request_sms = curl_init($post_url);  
        curl_setopt($request_sms, CURLOPT_HEADER, 0);  
        curl_setopt($request_sms, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($request_sms, CURLOPT_POSTFIELDS, $post_string); 
        curl_setopt($request_sms, CURLOPT_SSL_VERIFYPEER, FALSE);  
        $post_response = curl_exec($request_sms);
        curl_close ($request_sms);  
        $res = json_decode($post_response,true);
        if ($res['status'] == 'SUCCESS' ){
            $sms_applicant = new SmsApplicant;
            $sms_applicant->application_id =  $app->id;
            $sms_applicant->sms_id = $sms->id;
            $sms_applicant->sms_status = $sms->type;
            $sms_applicant->api_CamID = $res['CamID'];
            $sms_applicant->save();
            $follow_up=new FollowUp;
            $follow_up->application_id=$app->id;
            $follow_up->app_status="warned";
            $follow_up->status="Will be expired soon";
            $follow_up->created_date=Carbon::now();
            $follow_up->updated_by="system";
            $follow_up->sms_sent="success";
            $follow_up->mail_sent= $mail_status;
            $follow_up->updater_role='system';
            $follow_up->save();
        }else{
            $follow_up=new FollowUp;
            $follow_up->application_id=$app->id;
            $follow_up->app_status="warned";
            $follow_up->status="Will be expired soon";
            $follow_up->created_date=Carbon::now();
            $follow_up->updated_by="system";
            $follow_up->mail_sent= $mail_status;
            $follow_up->sms_sent="fail";
            $follow_up->updater_role='system';
            $follow_up->save();
        }*/

    }   
    if($mytime > $sticker->exp_date && $sticker->sms_exp_warn=='warned' && $sticker->sms_exp_expired=="will be expired" && !in_array($sticker->sticker_value, $excludeCategories)){
        $app = Application::findOrFail($sticker->application->id);
        $app->app_status = "expired";
        $app->renew="renew-expired";
        $app->save();
        $stick=VehicleSticker::findOrFail($sticker->id);
        $stick->sms_exp_warn="warned";
        $stick->sms_exp_expired="expired";
        $stick->save();            
        $sms=Sms::where('type', 'expired')->first();
        $sms_add_reg=str_replace('/reg/',$sticker->reg_number, $sms->sms_text); 
        $sms_final=str_replace('/date/',$sticker->exp_date, $sms_add_reg);
         /*Mail::to($app->applicant->email)->send(new notifyExpiredMail($sms_final));
            if (Mail::failures()){
              $mail_status="fail";
            }else{
              $mail_status="success";
            }*/


        HomeController::callSmsApi($sticker->applicant->phone, $sms_final);
        /*$post_url = 'http://smsportal.pigeonhost.com/smsapi' ;
        $post_values = array( 
            'api_key' => '3717862a00f88c6164a735d661d4e9c91c5d976779d0f7f488e3bbd945638118d222c6a8',
                'type' => 'text',  // unicode or text
                'senderid' => '8804445641111',
                'contacts' => $sticker->applicant->phone,
                'msg' => $sms_final,
                'method' => 'api'
            );

        $post_string = "";
        foreach( $post_values as $key => $value )
        { 
            $post_string .= "$key=" . urlencode( $value ) . "&"; 
        }
        $post_string = rtrim( $post_string, "& " );
        $request_sms = curl_init($post_url);  
        curl_setopt($request_sms, CURLOPT_HEADER, 0);  
        curl_setopt($request_sms, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($request_sms, CURLOPT_POSTFIELDS, $post_string); 
        curl_setopt($request_sms, CURLOPT_SSL_VERIFYPEER, FALSE);  
        $post_response = curl_exec($request_sms);
        curl_close ($request_sms);  
        $res = json_decode($post_response,true);
        if ($res['status'] == 'SUCCESS' ){
            $sms_applicant = new SmsApplicant;
            $sms_applicant->application_id =  $app->id;
            $sms_applicant->sms_id = $sms->id;
            $sms_applicant->sms_status = $sms->type;
            $sms_applicant->api_CamID = $res['CamID'];
            $sms_applicant->save();
            $follow_up=new FollowUp;
            $follow_up->application_id=$app->id;
            $follow_up->app_status="expired";
            $follow_up->status="Has been expired";
            $follow_up->created_date=Carbon::now();
            $follow_up->updated_by="system";
            $follow_up->updater_role="system";
            $follow_up->sms_sent="success";
            $follow_up->mail_sent= $mail_status;
            $follow_up->save(); 
        }else{
            $follow_up=new FollowUp;
            $follow_up->application_id=$app->id;
            $follow_up->app_status="expired";
            $follow_up->status="Has been expired";
            $follow_up->created_date=Carbon::now();
            $follow_up->updated_by="system";
            $follow_up->sms_sent="fail";
            $follow_up->updater_role='system';
            $follow_up->mail_sent= $mail_status;
            $follow_up->save();
        }*/


    }
}



}
}
