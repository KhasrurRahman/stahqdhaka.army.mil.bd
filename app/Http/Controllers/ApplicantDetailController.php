<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormValidate;
use Illuminate\Http\Request;
use App\Applicant;
use App\ApplicantDetail;
use App\Application;
use App\FollowUp;
use Auth;
use App\Notifications\ApplicationNotification;
use App\User;
use Carbon\Carbon; 
class ApplicantDetailController extends Controller
{
	public function storeApplicantDetails(FormValidate $request){
		$this->validate($request, [
			'applicant_photo' => 'image|mimes:jpg,jpeg,png',
			'applicant_nid_photo' => 'image|mimes:jpg,jpeg,png',
			'applicant_Def_id_photo' => 'image|mimes:jpg,jpeg,png',
		]);
		$application = null;
		if(empty(auth()->guard('applicant')->user()->applicantDetail->app_number) && empty(auth()->guard('applicant')->user()->applicantDetail->app_id)){
			$application = new Application;
			$application->app_number = (time()+rand(10,1000));
			$application->applicant_id=Auth::guard('applicant')->user()->id;
			$application->app_status="processing";
			$application->app_date=Carbon::now();
			$application->vehicle_type_id='';
			$application->type=Auth::guard('applicant')->user()->role;
			$application->remark=$request->applicant_remarks;
			$application->save();
		}

		if($request->applicant_name != auth()->guard('applicant')->user()->name || $request->applicant_phone != auth()->guard('applicant')->user()->phone || $request->applicant_email != auth()->guard('applicant')->user()->email ) {
			$applicant = Applicant::findOrFail(auth()->guard('applicant')->user()->id);
			$applicant->name = $request->applicant_name;
			$applicant->phone = $request->applicant_phone;
			$applicant->email = $request->applicant_email;
			$applicant->update();
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
				$ApplicantDetail->spouseOrParent_BA_no = $request->spouse_parent_BA_no;
				$ApplicantDetail->spouseOrParent_Name = $request->spouse_parent_name;
				$ApplicantDetail->spouseOrParent_Rank_id = $request->spouse_parents_rank;
				$ApplicantDetail->spouse_parents_units_id = $request->spouse_parents_unit;

			}else{

				$ApplicantDetail->applicant_BA_no = $request->BA_no;
				$ApplicantDetail->rank_id = $request->applicant_rank;
				if($request->is_retired!=""){
					$ApplicantDetail->is_applicant_retired = true;
				}
			}
			
			$ApplicantDetail->residence_type = $request->residence_type;
			$ApplicantDetail->tin = $request->applicant_tin;
			$ApplicantDetail->no_sticker_to_self_family = $request->sticker_num_to_self_family;
			$ApplicantDetail->allocated_current_sticker_type = $request->current_sticker_type;
			$ApplicantDetail->allocated_current_sticker_no = $request->current_sticker_no;
			$ApplicantDetail->applicant_remark = $request->applicant_remarks;
			$ApplicantDetail->app_number = $application->app_number;
			$ApplicantDetail->app_id = $application->id;
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
			if ($request->guardian == 1){
				$ApplicantDetail->husband_name="";
				$ApplicantDetail->father_name = $request->f_h_name;
			}
			else {
				$ApplicantDetail->father_name="";
				$ApplicantDetail->husband_name = $request->f_h_name;
			}
			$ApplicantDetail->address = json_encode($applicant_address);
			$ApplicantDetail->nid_number = $request->applicant_nid;
			$ApplicantDetail->profession = $request->profession;
			$ApplicantDetail->designation = $request->designation;
			$ApplicantDetail->company_name = $request->ap_company_name;

			if(!empty($ApplicantDetail->applicant_BA_no) && !empty($ApplicantDetail->rank_id) && $request->applicant_spouse_Or_child !='' && $request->spouse_parent_BA_no !=''){
				$flag = "not_your_account";
				$data = "You can not apply with your parent/spouse account";
				return (array($data,$flag));
			}elseif(!empty($ApplicantDetail->spouseOrParent_Name) && !empty($ApplicantDetail->spouseOrParent_BA_no) && $request->BA_no !='' && $request->applicant_rank !=''){
				$flag = "not_your_account";
				$data = "You can not apply with your spouse/children account";
				return (array($data,$flag));
			}
			if($request->applicant_spouse_Or_child !='' ){
				$ApplicantDetail->is_spouseOrChild = true;
				$ApplicantDetail->spouseOrParent_BA_no = $request->spouse_parent_BA_no;
				$ApplicantDetail->spouseOrParent_Name = $request->spouse_parent_name;
				$ApplicantDetail->spouseOrParent_Rank_id = $request->spouse_parents_rank;
				$ApplicantDetail->spouse_parents_units_id = $request->spouse_parents_unit;
			}else{
				$ApplicantDetail->is_spouseOrChild = false;
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
			if(empty($ApplicantDetail->app_number) && empty($ApplicantDetail->app_id)){
				$ApplicantDetail->app_number = $application->app_number;
				$ApplicantDetail->app_id = $application->id;
			}
			$ApplicantDetail->update();
		}
		
	}
	public function updateApplicantDetail($app_id, FormValidate $request){
		$this->validate($request, [
			'applicant_photo' => 'image|mimes:jpg,jpeg,png',
			'applicant_nid_photo' => 'image|mimes:jpg,jpeg,png',
			'applicant_Def_id_photo' => 'image|mimes:jpg,jpeg,png',
		]);


		$application = Application::findOrFail($app_id);
		if ($application) {
			$application->remark = $request->applicant_remarks;
			if (Auth::guard('applicant')->user() && $application->retake == 1) {
				
				$application->retake = 2;
			}
            
			$application->save();
		}
	
		

		$ApplicantDetail =ApplicantDetail::findOrFail($application->applicant->applicantDetail->id);
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

		if(!empty($ApplicantDetail->applicant_BA_no) && !empty($ApplicantDetail->rank_id) && $request->applicant_spouse_Or_child !='' && $request->spouse_parent_BA_no !=''){
			$flag = "not_your_account";
			$data = "You can not apply with your parent/spouse account";
			return (array($data,$flag));
		}elseif(!empty($ApplicantDetail->spouseOrParent_Name) && !empty($ApplicantDetail->spouseOrParent_BA_no) && $request->BA_no !='' && $request->applicant_rank !=''){
			$flag = "not_your_account";
			$data = "You can not apply with your spouse/children account";
			return (array($data,$flag));
		}
		if($request->applicant_spouse_Or_child !='' ){
			$ApplicantDetail->is_spouseOrChild = true;
			$ApplicantDetail->spouseOrParent_BA_no = $request->spouse_parent_BA_no;
			$ApplicantDetail->spouseOrParent_Name = $request->spouse_parent_name;
			$ApplicantDetail->spouseOrParent_Rank_id = $request->spouse_parents_rank;
			$ApplicantDetail->spouse_parents_units_id = $request->spouse_parents_unit;
		}else{
			$ApplicantDetail->is_spouseOrChild = false;
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
		$ApplicantDetail->update();
		// $ApplicantDetail->save();
		$applicant = Applicant::findOrFail($application->applicant->id);
		$applicant->name = $request->applicant_name;
		$applicant->phone = $request->applicant_phone;
		$applicant->email = $request->applicant_email;
		$applicant->update();
		$users= User::all();
		foreach ($users as $user) {
			if(!empty(auth()->guard('applicant')->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" => auth()->guard('applicant')->user()->name,
					"action" => "updated applicant detail",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			} 
			elseif(!empty(auth()->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" =>auth()->user()->name,
					"action" => "updated applicant detail",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			}
		}
		$follow_up=new FollowUp;
		$follow_up->application_id=$application->id;
		$follow_up->updater_role=!empty(auth()->guard('applicant')->user()->name)?'customer':auth()->user()->role;
		$follow_up->status="Applicant Info Updated";
		$follow_up->created_date=Carbon::now();
		$follow_up->updated_by=!empty(auth()->guard('applicant')->user()->name)?auth()->guard('applicant')->user()->name:auth()->user()->name;
		$follow_up->save();
		$flag = "success";
		$data = "Applicant Details Updated Successfully!";
		return (array($data,$flag));
	}

}
