<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;
use App\TemporaryPass;
use DB;
class TemporaryPassController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function temporaryPassPending(){
    	$temps=Application::where('sticker_category','T')->where('app_status','pending')->get();
    	return view('apps.temporary-pending',compact('temps'));
    }
    public function temporaryPassApproved(){
    	$temps=Application::where('sticker_category','T')->where('app_status','approved')->get();
    	return view('apps.temporary-approved',compact('temps'));
    }
    public function temporaryPassRejected(){
        $temps=Application::where('sticker_category','T')->where('app_status','rejected')->get();
        return view('apps.temporary-rejected',compact('temps'));
    }
    public function temporaryPassExpired(){
        $temps=Application::where('sticker_category','T')->where('app_status','expired')->get();
        return view('apps.temporary-expired',compact('temps'));
    }
}
