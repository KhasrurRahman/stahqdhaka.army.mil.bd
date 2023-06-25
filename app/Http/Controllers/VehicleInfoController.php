<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormValidate;

use Illuminate\Http\Request;
use App\Application;
use App\VehicleInfo;
use App\VehicleOwner;
use App\FollowUp;
use Auth;
use App\Notifications\ApplicationNotification;
use App\User;
use Carbon\Carbon;
class VehicleInfoController extends Controller
{
	public function storeVehicleDetails(FormValidate $request){
		$this->validate($request, [
			'vehicle_reg_photo' => 'nullable|mimes:jpg,jpeg,png',
			'insurance_cert_photo' => 'nullable|mimes:jpg,jpeg,png',
			'tax_token_photo' => 'nullable|mimes:jpg,jpeg,png',
			'fitness_cert_photo' => 'nullable|mimes:jpg,jpeg,png',
			'road_permit_photo' => 'nullable|mimes:jpg,jpeg,png',
			'entry_pass_photo' => 'nullable|mimes:jpg,jpeg,png',
			'jt_licence_photo' => 'nullable|mimes:jpg,jpeg,png',
		]);

	    if ($request->old_application_id){
            $old_vcehicle_info = VehicleInfo::where('application_id',$request->old_application_id)->first();
        }
		$exist_stickers = VehicleInfo::where('reg_number',$request->vehicle_reg_no)->get();
		$pending_count=0;
		$approve_count=0;
		if(count($exist_stickers)>0){
			foreach($exist_stickers as $exist_sticker){
				if($exist_sticker->application->app_status =='pending' ){
					$pending_count++;
				}
				if($exist_sticker->application->app_status =='approved' ){
					$approve_count++;
				}
			}
		}
		// dd($request->all());
		if($pending_count==0 && $approve_count==0){
			$existentVehicleinfo = VehicleInfo::where('application_id',auth()->guard('applicant')->user()->applicantDetail->app_id)->first();
			$existentOwnerinfo = VehicleOwner::where('application_id',auth()->guard('applicant')->user()->applicantDetail->app_id)->first();
			if(!empty($existentVehicleinfo) && !empty($existentOwnerinfo)){
				$VehicleInfo =VehicleInfo::findOrFail($existentVehicleinfo->id);
				$VehicleInfo->insurance_validity=$request->insurance_validity;
				$VehicleInfo->fitness_validity=$request->fitnness_validity;
				$VehicleInfo->tax_token_validity=$request->tax_paid_upto;
				$VehicleInfo->necessity_to_use=$request->necessity_to_use;
				$VehicleInfo->reg_number=$request->vehicle_reg_no;
				$VehicleInfo->vehicle_type_id=$request->vehicle_type;
				$VehicleInfo->loan_taken=$request->loan_taken;
				if ($request->is_not_transparent=='0'){
					$VehicleInfo->glass_type=$request->glass_type;
				}else{
					$VehicleInfo->glass_type='transparent';
				}
				$VehicleInfo->in_out_gate=$request->in_out_gate;
				$VehicleInfo->in_out_time=$request->in_out_time;

				if($request->hasFile('vehicle_reg_photo')){
					\File::delete('images/vehicle_reg/' . basename($VehicleInfo->reg_cert_photo));
					$vehicle_reg_filename = time() . '.' . $request->vehicle_reg_photo->getClientOriginalExtension();
					$vehicle_reg_name = '/images/vehicle_reg/' . $vehicle_reg_filename;
					$request->vehicle_reg_photo->move(public_path('images/vehicle_reg'), $vehicle_reg_name);
					$VehicleInfo->reg_cert_photo = $vehicle_reg_name;
				}else{

					$VehicleInfo->reg_cert_photo = $old_vcehicle_info->reg_cert_photo??'';
				}
				if($request->hasFile('insurance_cert_photo')) {
					\File::delete('images/vehicle_insurance/' . basename($VehicleInfo->insurance_cert_photo));

					$vehicle_insurance_filename = time() . '.' . $request->insurance_cert_photo->getClientOriginalExtension();
					$vehicle_insurance_name = '/images/vehicle_insurance/' . $vehicle_insurance_filename;
					$request->insurance_cert_photo->move(public_path('images/vehicle_insurance'), $vehicle_insurance_name);
					$VehicleInfo->insurance_cert_photo = $vehicle_insurance_name;
				}else{
					$VehicleInfo->insurance_cert_photo = $old_vcehicle_info->insurance_cert_photo??'';
				}
				if($request->hasFile('tax_token_photo')) {
					\File::delete('images/vehicle_tax_token/' . basename($VehicleInfo->tax_token_photo));

					$vehicle_tax_token_filename = time() . '.' . $request->tax_token_photo->getClientOriginalExtension();
					$vehicle_tax_token_name = '/images/vehicle_tax_token/' . $vehicle_tax_token_filename;
					$request->tax_token_photo->move(public_path('images/vehicle_tax_token'), $vehicle_tax_token_name);
					$VehicleInfo->tax_token_photo = $vehicle_tax_token_name;
				}else{
					$VehicleInfo->tax_token_photo = $old_vcehicle_info->tax_token_photo??'';
				}
				if($request->hasFile('fitness_cert_photo')){
					\File::delete('images/vehicle_fitness/' . basename($VehicleInfo->fitness_cert_photo));

					$vehicle_fitness_filename = time() . '.' . $request->fitness_cert_photo->getClientOriginalExtension();
					$vehicle_fitness_name = '/images/vehicle_fitness/'.$vehicle_fitness_filename;
					$request->fitness_cert_photo->move(public_path('images/vehicle_fitness'), $vehicle_fitness_name);
					$VehicleInfo->fitness_cert_photo = $vehicle_fitness_name;
				}else{
					$VehicleInfo->fitness_cert_photo = $old_vcehicle_info->fitness_cert_photo??'';
				}
				$VehicleInfo->update();
				$VehicleOwner =VehicleOwner::findOrFail($existentOwnerinfo->id);
				$com_address=array(
					"flat" => $request->c_flat,
					"house" => $request->c_house,
					"road" => $request->c_road,
					"block" => $request->c_block,
					"area" => $request->c_area,
				);
				if($request->owner_is_company == "1"){
					$VehicleOwner->company_name= $request->company_name;
					$VehicleOwner->company_address=json_encode($com_address);
				}else{
					$VehicleOwner->company_name= '';
					$VehicleOwner->company_address=null;
				}
				$VehicleOwner->owner_name= $request->owner_name;
				$VehicleOwner->update();
				$app = Application::findOrFail($VehicleInfo->application_id);
				$app->vehicle_type_id = $request->vehicle_type;
				if ($request->is_not_transparent=='0'){
					$app->glass_type=$request->glass_type;
				}else{
					$app->glass_type='transparent';
				}
				$app->update();
			}else{
				$VehicleInfo = new VehicleInfo;
				$VehicleInfo->application_id=auth()->guard('applicant')->user()->applicantDetail->app_id;
				$VehicleInfo->app_number=auth()->guard('applicant')->user()->applicantDetail->app_number;
				$VehicleInfo->insurance_validity=$request->insurance_validity;
				$VehicleInfo->fitness_validity=$request->fitnness_validity;
				$VehicleInfo->tax_token_validity=$request->tax_paid_upto;
				$VehicleInfo->necessity_to_use=$request->necessity_to_use;
				$VehicleInfo->reg_number=$request->vehicle_reg_no;
				$VehicleInfo->vehicle_type_id=$request->vehicle_type;
				$VehicleInfo->loan_taken=$request->loan_taken;
				if ($request->is_not_transparent=='0'){
					$VehicleInfo->glass_type=$request->glass_type;
				}else{
					$VehicleInfo->glass_type='transparent';
				}
				$VehicleInfo->in_out_gate=$request->in_out_gate;
				$VehicleInfo->in_out_time=$request->in_out_time;
				if($request->hasFile('vehicle_reg_photo')){
					$vehicle_reg_filename = time() . '.' . $request->vehicle_reg_photo->getClientOriginalExtension();
					$vehicle_reg_name ='/images/vehicle_reg/'.$vehicle_reg_filename;
					$request->vehicle_reg_photo->move(public_path('images/vehicle_reg'), $vehicle_reg_name);
					$VehicleInfo->reg_cert_photo = $vehicle_reg_name;
				}else{

                    $VehicleInfo->reg_cert_photo = $old_vcehicle_info->reg_cert_photo ?? '';
                }
				if(!empty($request->renew_request) && $request->renew_request=='yes' && empty($request->hasFile('vehicle_reg_photo'))){
					$old_app = Application::findOrFail($request->app_id);
					$VehicleInfo->reg_cert_photo=$old_app->vehicleinfo->reg_cert_photo;
				}
				if($request->hasFile('tax_token_photo')){
					$vehicle_tax_token_filename = time() . '.' . $request->tax_token_photo->getClientOriginalExtension();
					$vehicle_tax_token_name ='/images/vehicle_tax_token/'.$vehicle_tax_token_filename;
					$request->tax_token_photo->move(public_path('images/vehicle_tax_token'), $vehicle_tax_token_name);
					$VehicleInfo->tax_token_photo = $vehicle_tax_token_name;
				}else{

                    $VehicleInfo->tax_token_photo = $old_vcehicle_info->tax_token_photo ?? '';
                }

				if($request->hasFile('insurance_cert_photo')){
					$vehicle_insurance_filename = time() . '.' . $request->insurance_cert_photo->getClientOriginalExtension();
					$vehicle_insurance_name ='/images/vehicle_insurance/'.$vehicle_insurance_filename;
					$request->insurance_cert_photo->move(public_path('images/vehicle_insurance'), $vehicle_insurance_name);
					$VehicleInfo->insurance_cert_photo = $vehicle_insurance_name;
				}else{

                    $VehicleInfo->insurance_cert_photo = $old_vcehicle_info->insurance_cert_photo ?? '';
                }
				if($request->hasFile('fitness_cert_photo')){
					$vehicle_fitness_filename = time() . '.' . $request->fitness_cert_photo->getClientOriginalExtension();
					$vehicle_fitness_name = '/images/vehicle_fitness/'.$vehicle_fitness_filename;
					$request->fitness_cert_photo->move(public_path('images/vehicle_fitness'), $vehicle_fitness_name);
					$VehicleInfo->fitness_cert_photo = $vehicle_fitness_name;
				}else{

                    $VehicleInfo->fitness_cert_photo = $old_vcehicle_info->fitness_cert_photo ?? '';
                }
				if($request->hasFile('road_permit_photo')){
					$road_permit_filename = time() . '.' . $request->road_permit_photo->getClientOriginalExtension();
					$road_permit_name = '/images/vehicle_road_permit/'.$road_permit_filename;
					$request->road_permit_photo->move(public_path('images/vehicle_road_permit'), $road_permit_name);
					$VehicleInfo->road_permit_photo = $road_permit_name;
				}else{

                    $VehicleInfo->road_permit_photo = $old_vcehicle_info->road_permit_photo ?? '';
                }
				if($request->hasFile('entry_pass_photo')){
					$vehicle_port_entry_pass_filename = time() . '.' . $request->entry_pass_photo->getClientOriginalExtension();
					$vehicle_port_entry_pass_name = '/images/vehicle_port_pass/'.$vehicle_port_entry_pass_filename;
					$request->entry_pass_photo->move(public_path('images/vehicle_port_pass'), $vehicle_port_entry_pass_name);
					$VehicleInfo->port_entry_pass_photo = $vehicle_port_entry_pass_name;
				}else{

                    $VehicleInfo->port_entry_pass_photo = $old_vcehicle_info->port_entry_pass_photo ?? '';
                }
				if($request->hasFile('jt_licence_photo')){
					$vehicle_jt_licence_copy_filename = time() . '.' . $request->jt_licence_photo->getClientOriginalExtension();
					$vehicle_jt_licence_copy_name = '/images/vehicle_jt_licence/'.$vehicle_jt_licence_copy_filename;
					$request->jt_licence_photo->move(public_path('images/vehicle_jt_licence'), $vehicle_jt_licence_copy_name);
					$VehicleInfo->jt_licence_photo = $vehicle_jt_licence_copy_name;
				}else{

                    $VehicleInfo->jt_licence_photo = $old_vcehicle_info->jt_licence_photo ?? '';
                }
				$VehicleInfo->save();
				$VehicleOwner = new VehicleOwner;
				$VehicleOwner->application_id=auth()->guard('applicant')->user()->applicantDetail->app_id;
				$VehicleOwner->app_number=auth()->guard('applicant')->user()->applicantDetail->app_number;
				$com_address=array(
					"flat" => $request->c_flat,
					"house" => $request->c_house,
					"road" => $request->c_road,
					"block" => $request->c_block,
					"area" => $request->c_area,
				);
				if($request->owner_is_company == "1"){
					$VehicleOwner->company_name= $request->company_name;
					$VehicleOwner->company_address=json_encode($com_address);
				}
				$VehicleOwner->owner_name= $request->owner_name;
				if(!empty($request->renew_request) && $request->renew_request=='yes' && empty($request->hasFile('owner_nid_photo'))){
					$old_app = Application::findOrFail($request->app_id);
					$VehicleOwner->nid_photo=$old_app->vehicleowner->nid_photo;
				}
				$VehicleOwner->save();
				$app = Application::findOrFail($VehicleInfo->application_id);
				$app->vehicle_type_id = $request->vehicle_type;
				if ($request->is_not_transparent=='0'){
					$app->glass_type=$request->glass_type;
				}else{
					$app->glass_type='transparent';
				}
				$app->update();
			}
		}else{
			$data ="You have already applied for this vehicle.";
			$flag ="already-applied";
			return (array($data, $flag));
		}
	}
	public function vehicleInfoUpdate($app_id, FormValidate $request){


		$this->validate($request, [
			'vehicle_reg_photo' => 'nullable|mimes:jpg,jpeg,png',
			'insurance_cert_photo' => 'nullable|mimes:jpg,jpeg,png',
			'tax_token_photo' => 'nullable|mimes:jpg,jpeg,png',
			'fitness_cert_photo' => 'nullable|mimes:jpg,jpeg,png',
			'road_permit_photo' => 'nullable|mimes:jpg,jpeg,png',
			'entry_pass_photo' => 'nullable|mimes:jpg,jpeg,png',
			'jt_licence_photo' => 'nullable|mimes:jpg,jpeg,png',
		]);

		$application = Application::findOrFail($app_id);

        if (Auth::guard('applicant')->user() && $application->retake == 1) {
            $application->retake = 2;
        }

        $application->save();
		$VehicleInfo =VehicleInfo::findOrFail($application->vehicleinfo->id);

		$VehicleInfo->insurance_validity=$request->insurance_validity;
		$VehicleInfo->fitness_validity=$request->fitnness_validity;
		$VehicleInfo->tax_token_validity=$request->tax_paid_upto;
		$VehicleInfo->necessity_to_use=$request->necessity_to_use;
		$VehicleInfo->reg_number=$request->vehicle_reg_no;
		$VehicleInfo->vehicle_type_id=$request->vehicle_type;
		$VehicleInfo->loan_taken=$request->loan_taken;
		if ($request->is_not_transparent=='1'){
			$VehicleInfo->glass_type=$request->glass_type;
		}else{
			$VehicleInfo->glass_type='transparent';
		}
		$VehicleInfo->in_out_gate=$request->in_out_gate;
		$VehicleInfo->in_out_time=$request->in_out_time;

		if($request->hasFile('vehicle_reg_photo')){
			\File::delete('images/vehicle_reg/' . basename($VehicleInfo->reg_cert_photo));
			$vehicle_reg_filename = time() . '.' . $request->vehicle_reg_photo->getClientOriginalExtension();
			$vehicle_reg_name = '/images/vehicle_reg/' . $vehicle_reg_filename;
			$request->vehicle_reg_photo->move(public_path('images/vehicle_reg'), $vehicle_reg_name);
			$VehicleInfo->reg_cert_photo = $vehicle_reg_name;
		}else{
			$old_app = Application::findOrFail($request->app_id);
			$VehicleInfo->tax_token_photo = $old_app->vehicleinfo->vehicle_reg_photo;
		}
		if($request->hasFile('insurance_cert_photo')) {
			\File::delete('images/vehicle_insurance/' . basename($VehicleInfo->insurance_cert_photo));
			$vehicle_insurance_filename = time() . '.' . $request->insurance_cert_photo->getClientOriginalExtension();
			$vehicle_insurance_name = '/images/vehicle_insurance/' . $vehicle_insurance_filename;
			$request->insurance_cert_photo->move(public_path('images/vehicle_insurance'), $vehicle_insurance_name);
			$VehicleInfo->insurance_cert_photo = $vehicle_insurance_name;
		}else{
			$old_app = Application::findOrFail($request->app_id);
			$VehicleInfo->insurance_cert_photo = $old_app->vehicleinfo->insurance_cert_photo;
		}
		if($request->hasFile('tax_token_photo')) {
			\File::delete('images/vehicle_tax_token/' . basename($VehicleInfo->tax_token_photo));
			$vehicle_tax_token_filename = time() . '.' . $request->tax_token_photo->getClientOriginalExtension();
			$vehicle_tax_token_name = '/images/vehicle_tax_token/' . $vehicle_tax_token_filename;
			$request->tax_token_photo->move(public_path('images/vehicle_tax_token'), $vehicle_tax_token_name);
			$VehicleInfo->tax_token_photo = $vehicle_tax_token_name;
		}else{
			$old_app = Application::findOrFail($request->app_id);
			$VehicleInfo->tax_token_photo = $old_app->vehicleinfo->tax_token_photo;
		}
		if($request->hasFile('fitness_cert_photo')){
			\File::delete('images/vehicle_fitness/' . basename($VehicleInfo->fitness_cert_photo));
			$vehicle_fitness_filename = time() . '.' . $request->fitness_cert_photo->getClientOriginalExtension();
			$vehicle_fitness_name = '/images/vehicle_fitness/'.$vehicle_fitness_filename;
			$request->fitness_cert_photo->move(public_path('images/vehicle_fitness'), $vehicle_fitness_name);
			$VehicleInfo->fitness_cert_photo = $vehicle_fitness_name;
		}else{
			$old_app = Application::findOrFail($request->app_id);
			$VehicleInfo->fitness_cert_photo = $old_app->vehicleinfo->fitness_cert_photo;
		}
		$VehicleInfo->save();

		$VehicleOwner =VehicleOwner::findOrFail($application->vehicleowner->id);
		$com_address=array(
			"flat" => $request->c_flat,
			"house" => $request->c_house,
			"road" => $request->c_road,
			"block" => $request->c_block,
			"area" => $request->c_area,
		);
		if($request->owner_is_company == "1"){
			$VehicleOwner->company_name= $request->company_name;
			$VehicleOwner->company_address=json_encode($com_address);
		}else{
			$VehicleOwner->company_name= '';
			$VehicleOwner->company_address=null;
		}
		$VehicleOwner->owner_name= $request->owner_name;
		$VehicleOwner->save();
		$follow_up=new FollowUp;
		$follow_up->application_id=$application->id;
		$follow_up->updater_role=!empty(auth()->guard('applicant')->user()->name)?'customer':auth()->user()->role;
		$follow_up->status="Vehicle Info Updated";
		$follow_up->created_date=Carbon::now();
		$follow_up->updated_by=!empty(auth()->guard('applicant')->user()->name)?auth()->guard('applicant')->user()->name:auth()->user()->name;
		$follow_up->save();
		$users= User::all();
		foreach ($users as $user) {
			if(!empty(auth()->guard('applicant')->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" => auth()->guard('applicant')->user()->name,
					"action" => "updated vehicle detail",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			}
			elseif(!empty(auth()->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" =>auth()->user()->name,
					"action" => "updated vehicle detail",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			}
		}
		$flag ="success";
		$data ="Vehicle Detail Updated Successfully!";
		return (array($data, $flag));
	}
}
