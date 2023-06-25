<?php

namespace App\Http\Controllers\CustomerAuth;

use App\Applicant;
use App\Http\Controllers\HomeController;
use App\PasswordResetSMS;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordSMSController extends Controller
{
    public function index() {
        return view('customer-auth.sms.mobile');
    }

    public function sendVerificationCode(Request $request) {
        $applicant = Applicant::where('phone', $request->mobile)->first();

        if (!$applicant) {
            return redirect()->back()->with('status', 'Mobile Number Not Found.');
        } else {
            $verificationCode = rand(10,1000000);
            $sms = "আপনার ভেরিফিকেশন কোডঃ ". $verificationCode ." । ধন্যবাদ।";

            HomeController::callSmsApi($applicant->phone, $sms);

            $passwordReset = new PasswordResetSMS();
            $passwordReset->applicant_id = $applicant->id;
            $passwordReset->verification_code = $verificationCode;
            $passwordReset->verification_code_expire_at = date('Y-m-d H:i:s', strtotime('+5 minute'));
            $passwordReset->link_expire_at = date('Y-m-d H:i:s', strtotime('+12 hours'));
            $passwordReset->save();

            return redirect()->route('customer.password.sms.verify');
        }
    }

    public function verify() {
        return view('customer-auth.sms.verify_verification_code');
    }

    public function verifyPost(Request $request) {
        $passwordReset = PasswordResetSMS::where('verification_code', $request->code)->latest()->first();

        if (!$passwordReset) {
            return redirect()->back()->with('status', 'Invalid Code.');
        } else {
            $now = strtotime(date('Y-m-d H:i:s'));
            $expireAt = strtotime($passwordReset->verification_code_expire_at);

            if ($now > $expireAt) {
                return redirect()->back()->with('status', 'Verification Time Expired');
            }

            return redirect()->route('customer.password.sms.reset', ['token' => encrypt($passwordReset->id)]);
        }
    }

    public function reset(Request $request) {
        if (!$request->token || $request->token == '')
            return 'Token not found.';

        try {
            $id = decrypt($request->token);
        } catch (DecryptException $e) {
            return 'Invalid Token.';
        }

        $passwordReset = PasswordResetSMS::findOrFail($id);

        $now = strtotime(date('Y-m-d H:i:s'));
        $expireAt = strtotime($passwordReset->link_expire_at);

        if ($now > $expireAt) {
            return 'Link Expire.';
        }

        return view('customer-auth.sms.reset');
    }

    public function resetPost(Request $request) {
        try {
            $id = decrypt($request->token);
        } catch (DecryptException $e) {
            return 'Invalid Token.';
        }

        $passwordReset = PasswordResetSMS::findOrFail($id);

        $now = strtotime(date('Y-m-d H:i:s'));
        $expireAt = strtotime($passwordReset->link_expire_at);

        if ($now > $expireAt) {
            return 'Link Expire.';
        }

        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $applicant = Applicant::find($passwordReset->applicant_id);
        $applicant->password = bcrypt($request->password);
        $applicant->save();

        $passwordReset->delete();

        $bn= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $banglaPhone = str_replace($en, $bn, $applicant->phone);
        $sms = 'আপনার পাসওয়ার্ড সফলভাবে পুনঃস্থাপন হয়েছে। মোবাইল: '.$banglaPhone.' পাসওয়ার্ডঃ '. $request->password;

        HomeController::callSmsApi($applicant->phone, $sms);

        return redirect()->route('customer.password.sms.success');
    }

    public function success() {
        return view('customer-auth.sms.success');
    }
}
