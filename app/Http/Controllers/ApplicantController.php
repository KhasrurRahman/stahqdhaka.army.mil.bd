<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Application;
use App\StickerCategory;
use App\SpouseParentsUnit;
use App\Rank;

use Illuminate\Http\Request;
use App\VehicleType;
class ApplicantController extends Controller
{
	 public function __construct()
    {
        $this->middleware('applicant');
    }

      public function applyForm(){

	     $stickers=StickerCategory::all();
      	$vehicleTypes=VehicleType::orderBy('name','ASC')->get();
        $ranks = Rank::orderBy('name','ASC')->get();
        $units = SpouseParentsUnit::orderBy('name','ASC')->get();


        $file_name_nid = null;
      // dd($units);
    	return view('applyForm',compact('stickers','vehicleTypes','ranks','units','file_name_nid'));
    }   
    
    public function showAppliedForms(){
    	return view('layouts.applied-forms');
    }

    
}
