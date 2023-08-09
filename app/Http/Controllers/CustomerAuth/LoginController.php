<?php

namespace App\Http\Controllers\CustomerAuth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class LoginController extends Controller
{
    protected $phone = 'phone';

    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 2; // Default is 1


    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function username()
    {
        return 'phone';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/about/customer';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }
    protected function guard()
    {
        return auth()->guard('applicant');
    }

    public function showLoginForm()
    {
        return view('customer-auth.login');
    }

    public function login(\Illuminate\Http\Request $request)
    {
        $this->validateLogin($request);
//  dd( session()->all());
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->active && $this->attemptLogin($request)) {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {

                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);

                $applicant = \App\Applicant::findOrFail($user->id);
                $applicant->verification_code = rand(10, 1000000);
                $applicant->verification_time_start = date("Y-m-d H:i:s");
                $applicant->update();
                $sms = "আপনার ভেরিফিকেশন কোডঃ " . $applicant->verification_code . " । ধন্যবাদ। ";
                HomeController::callSmsApi($applicant->phone, $sms);
                session()->put('verified', false);
                session()->put('user', $applicant);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['active' => 'You must be verified to login.']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function verifyLogin(Request $req)
    {

        $user = session()->get('user');

        $now_date = date("Y-m-d H:i:s");
        $date = new DateTime($user->verification_time_start);
        $date2 = new DateTime($now_date);
        $diff = $date2->getTimestamp() - $date->getTimestamp();


        if ($diff <= 600) {
            if ($req->verify_code == $user->verification_code) {
                $applicant = \App\Applicant::findOrFail($user->id);
                $applicant->active = 1;
                $applicant->update();
                Auth::guard('applicant')->login($user);
                session()->forget('verified');
                session()->forget('user');
                return redirect($this->redirectTo);
            } else {
                session()->flash('message', 'invalid code');
                \Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }


        } else {
            session()->forget('verified');
            session()->forget('user');
            session()->flash('message', 'Verification Time Expired');
            \Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }


        //  if(){

        //  }
  
    }

    public function logout()
    {
        $applicant = \App\Applicant::findOrFail(auth()->guard('applicant')->user()->id);
        $applicant->active = 0;
        $applicant->update();
        Auth::guard('applicant')->logout();
        session()->regenerate();
        session()->forget('verified');
        return redirect('/customer/login');
    }

}
