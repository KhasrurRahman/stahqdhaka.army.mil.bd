<?php

namespace App\Http\Controllers;
use App\Http\Requests\FormValidate;
use Illuminate\Http\Request;
use App\Application;
use App\DriverInfo;
use App\Document;
use App\FollowUp;
use Carbon\Carbon;
use App\ApplicantDetail;
use App\Notifications\ApplicationNotification;
use App\User;
use App\VehicleInfo;
use Auth;

class DriverInfoController extends Controller
{
	public function storeDriverDetails(FormValidate $request){
		$this->validate($request, [
			'licence_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'nid_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'org_id_photo' => 'nullable|image|mimes:jpg,jpeg,png'
		]);

		// $existent_driverInfo=DriverInfo::where('application_id',auth()->guard('applicant')->user()->applicantDetail->app_id)->first();

        if ($request->old_application_id){
            $old_driver_info = DriverInfo::where('application_id',$request->old_application_id)->first();
        }

        $existent_driverInfo=DriverInfo::where('application_id',auth()->guard('applicant')->user()->applicantDetail->app_id)->first();
		if(!empty($existent_driverInfo)){
			$DriverInfo = DriverInfo::findOrFail($existent_driverInfo->id);
			if( $request->self_driven == '1'){
				if($DriverInfo->driver_is_owner!='1'){
					\File::delete('images/driver_nid/' . basename($DriverInfo->nid_photo));
					$DriverInfo->nid_photo='';
					\File::delete('images/driver_photo/' . basename($DriverInfo->photo));
					$DriverInfo->photo='';
					if($request->hasFile('licence_photo')) {
						\File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));

						$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
						$driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
						$request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
						$DriverInfo->licence_photo = $driver_licence_name;
					}else{

					    $DriverInfo->licence_photo = $old_driver_info->licence_photo ?? '';
                    }
					$DriverInfo->name ='';
					$DriverInfo->nid_number =null;
					$DriverInfo->address ='';
					$DriverInfo->driver_is_owner='1';
					$DriverInfo->save();
				}else{
					if($request->hasFile('licence_photo')) {
						\File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));
						$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
						$driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
						$request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
						$DriverInfo->licence_photo = $driver_licence_name;
					}else{

                        $DriverInfo->licence_photo = $old_driver_info->licence_photo ?? '';
                    }
					$DriverInfo->save();
				}
			}
			if($request->self_driven != '1'){
				if($DriverInfo->driver_is_owner=='1'){
					$DriverInfo->driver_is_owner=null;
				}
				if($request->hasFile('licence_photo')) {
					\File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));
					$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
					$driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
					$request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
					$DriverInfo->licence_photo = $driver_licence_name;
				}else{

                    $DriverInfo->licence_photo = $old_driver_info->licence_photo ?? '';
                }
				$DriverInfo->name =$request->name;
				$DriverInfo->nid_number = $request->nid_number;
				$present_address = array(
					"flat" => $request->dri_pre_flat,
					"house" => $request->dri_pre_house,
					"road" => $request->dri_pre_road,
					"block" => $request->dri_pre_block,
					"area" => $request->dri_pre_area,
				);
				$permanent_address = array(
					"p_flat" => $request->dri_per_flat,
					"p_house" => $request->dri_per_house,
					"p_road" => $request->dri_per_road,
					"p_block" => $request->dri_per_block,
					"p_area" => $request->dri_per_area,
				);
				$driver_address =array(
					"present" => $present_address,
					"permanent" => $permanent_address,
				);
				$DriverInfo->address =json_encode($driver_address);
				if( $request->hasFile('nid_photo')){
					\File::delete('images/driver_nid/' . basename($DriverInfo->nid_photo));

					$driver_nid_fileName = time() . '.' . $request->nid_photo->getClientOriginalExtension();
					$driver_nid_name = '/images/driver_nid/' . $driver_nid_fileName;
					$request->nid_photo->move(public_path('images/driver_nid'), $driver_nid_name);
					$DriverInfo->nid_photo = $driver_nid_name;
				}else{

                    $DriverInfo->nid_photo = $old_driver_info->nid_photo ?? '';
                }
				if($request->hasFile('photo')) {
					\File::delete('images/driver_photo/' . basename($DriverInfo->photo));

					$driver_photo_fileName = time() . '.' . $request->photo->getClientOriginalExtension();
					$driver_photo_name = '/images/driver_photo/' . $driver_photo_fileName;
					$request->photo->move(public_path('images/driver_photo'), $driver_photo_name);
					$DriverInfo->photo = $driver_photo_name;
				}else{

                    $DriverInfo->photo = $old_driver_info->photo ?? '';
                }
				$DriverInfo->save();
			}
		}else{
			$DriverInfo = new DriverInfo;
			$DriverInfo->application_id=auth()->guard('applicant')->user()->applicantDetail->app_id;
			$DriverInfo->app_number =auth()->guard('applicant')->user()->applicantDetail->app_number;

			if ($request->self_driven == '1')
			{
				$DriverInfo->driver_is_owner = $request->self_driven;
				if($request->hasFile('licence_photo')){
					$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
					$driver_licence_name ='/images/driver_licence/'.$driver_licence_filename;
					$request->licence_photo->move(public_path('images/driver_licence'),$driver_licence_name);
					$DriverInfo->licence_photo = $driver_licence_name;
				}else{

                    $DriverInfo->licence_photo = $old_driver_info->licence_photo ?? '';
                }
			}
			else{
				if($request->hasFile('licence_photo')){
					$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
					$driver_licence_name ='/images/driver_licence/'.$driver_licence_filename;
					$request->licence_photo->move(public_path('images/driver_licence'),$driver_licence_name);
					$DriverInfo->licence_photo = $driver_licence_name;
				}else{

                    $DriverInfo->licence_photo = $old_driver_info->licence_photo ?? '';
                }
				$DriverInfo->name =$request->name;
				$DriverInfo->nid_number = $request->nid_number;
				$present_address = array(
					"flat" => $request->dri_pre_flat,
					"house" => $request->dri_pre_house,
					"road" => $request->dri_pre_road,
					"block" => $request->dri_pre_block,
					"area" => $request->dri_pre_area,
				);
				$permanent_address = array(
					"p_flat" => $request->dri_per_flat,
					"p_house" => $request->dri_per_house,
					"p_road" => $request->dri_per_road,
					"p_block" => $request->dri_per_block,
					"p_area" => $request->dri_per_area,
				);
				$driver_address =array(
					"present" => $present_address,
					"permanent" => $permanent_address,
				);

				$DriverInfo->address =json_encode($driver_address);
				if($request->hasFile('photo')){
					$driver_photo_fileName = time() . '.' . $request->photo->getClientOriginalExtension();
					$driver_photo_name = '/images/driver_photo/'.$driver_photo_fileName;
					$request->photo->move(public_path('images/driver_photo'), $driver_photo_name);
					$DriverInfo->photo = $driver_photo_name;
				}else{

                    $DriverInfo->photo = $old_driver_info->photo ?? '';
                }
				if($request->hasFile('nid_photo')){
					$driver_nid_fileName = time() . '.' . $request->nid_photo->getClientOriginalExtension();
					$driver_nid_name = '/images/driver_nid/'.$driver_nid_fileName;
					$request->nid_photo->move(public_path('images/driver_nid'), $driver_nid_name);
					$DriverInfo->nid_photo = $driver_nid_name;
				}else{

                    $DriverInfo->nid_photo = $old_driver_info->nid_photo ?? '';
                }

				if($request->hasFile('org_id_photo')){
					$driver_org_id_fileName = time() . '.' . $request->org_id_photo->getClientOriginalExtension();
					$driver_org_id_name ='/images/driver_org_id/'.$driver_org_id_fileName;
					$request->org_id_photo->move(public_path('images/driver_org_id'), $driver_org_id_name);
					$DriverInfo->org_id_photo = $driver_org_id_name;
				}else{

                    $DriverInfo->org_id_photo = $old_driver_info->org_id_photo ?? '';
                }
			}
			$DriverInfo->save();
		}




	}
	public function storeDocuments(FormValidate $request){

		$this->validate($request, [
			'school_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'civil_service_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'job_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'auth_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'ward_com_cert' => 'nullable|image|mimes:jpg,jpeg,png',
			'house_owner_cert' => 'nullable|image|mimes:jpg,jpeg,png',
			'marriage_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'mother_testm_photo' => 'nullable|image|mimes:jpg,jpeg,png',
		]);

        if ($request->old_application_id){
            $old_document_info = Document::where('application_id',$request->old_application_id)->first();
        }
        //dd($old_document_info);

		$Document = new Document;
		$Document->application_id = auth()->guard('applicant')->user()->applicantDetail->app_id;
		if($request->hasFile('school_cert_photo')){
			$school_cert_name = time() . '.' . $request->school_cert_photo->getClientOriginalExtension();
			$school_cert_file_name ='/images/school_cert/'.$school_cert_name;
			$request->school_cert_photo->move(public_path('images/school_cert'), $school_cert_file_name);
			$Document->school_cert = $school_cert_file_name;
		}else{
		    $Document->school_cert = $old_document_info->school_cert ?? '';
        }
		if($request->hasFile('civil_service_photo')){
			$civil_service_id = time() . '.' . $request->civil_service_photo->getClientOriginalExtension();
			$civil_service_idFile ='/images/civil_service_id/'.$civil_service_id;
			$request->civil_service_photo->move(public_path('images/civil_service_id'), $civil_service_idFile);
			$Document->civil_service_id = $civil_service_idFile;
		}else{
            $Document->civil_service_id = $old_document_info->civil_service_id ?? '';
        }
		if($request->hasFile('job_cert_photo')){
			$job_cert_name = time() . '.'  .  $request->job_cert_photo->getClientOriginalExtension();
			$job_cert_filename ='/images/job_cert_photo/'.$job_cert_name;
			$request->job_cert_photo->move(public_path('images/job_cert_photo'), $job_cert_filename);
			$Document->job_cert = $job_cert_filename;
		}else{
            $Document->job_cert = $old_document_info->job_cert ?? '';
        }
		if($request->hasFile('auth_cert_photo')){
			$auth_cert_name = time() . '.'  .  $request->auth_cert_photo->getClientOriginalExtension();
			$auth_cert_filename ='/images/auth_cert_photo/'.$auth_cert_name;
			$request->auth_cert_photo->move(public_path('images/auth_cert_photo'), $auth_cert_filename);
			$Document->auth_cert = $auth_cert_filename;
		}else{
            $Document->auth_cert = $old_document_info->auth_cert ?? '';
        }
		if($request->hasFile('ward_com_cert')){
			$ward_com_certname = time() . '.'  .  $request->ward_com_cert->getClientOriginalExtension();
			$ward_com_certnamefile ='/images/ward_com_cert/'.$ward_com_certname;
			$request->ward_com_cert->move(public_path('images/ward_com_cert'), $ward_com_certnamefile);
			$Document->ward_comm_cert = $ward_com_certnamefile;
		}else{
            $Document->ward_comm_cert = $old_document_info->ward_comm_cert ?? '';
        }
		if($request->hasFile('house_owner_cert')){
			$house_owner_certname = time() . '.'  .  $request->house_owner_cert->getClientOriginalExtension();
			$house_owner_certnamefile ='/images/house_owner_cert/'.$house_owner_certname;
			$request->house_owner_cert->move(public_path('images/house_owner_cert'), $house_owner_certnamefile);
			$Document->house_owner_cert = $house_owner_certnamefile;
		}else{
            $Document->house_owner_cert = $old_document_info->house_owner_cert ?? '';
        }
		if($request->hasFile('marriage_cert_photo')){
			$marriage_cert_photoname = time() . '.'  .  $request->marriage_cert_photo->getClientOriginalExtension();
			$marriage_cert_photonamefile ='/images/marriage_cert_photo/'.$marriage_cert_photoname;
			$request->marriage_cert_photo->move(public_path('images/marriage_cert_photo'), $marriage_cert_photonamefile);
			$Document->marriage_cert = $marriage_cert_photonamefile;
		}else{
            $Document->marriage_cert = $old_document_info->marriage_cert ?? '';
        }
		if($request->hasFile('father_testm_photo')){
			$father_testm_photoname = time() . '.'  .  $request->father_testm_photo->getClientOriginalExtension();
			$father_testm_photonamefile ='/images/father_testm_photo/'.$father_testm_photoname;
			$request->father_testm_photo->move(public_path('images/father_testm_photo'), $father_testm_photonamefile);
			$Document->father_testm = $father_testm_photonamefile;
		}else{
            $Document->father_testm = $old_document_info->father_testm ?? '';
        }
		if($request->hasFile('mother_testm_photo')){
			$mother_testm_photoname = time() . '.'  .  $request->mother_testm_photo->getClientOriginalExtension();
			$mother_testm_photonamefile ='/images/mother_testm_photo/'.$mother_testm_photoname;
			$request->mother_testm_photo->move(public_path('images/mother_testm_photo'), $mother_testm_photonamefile);
			$Document->mother_testm = $mother_testm_photonamefile;
		}else{
            $Document->mother_testm = $old_document_info->mother_testm ?? '';
        }
		$Document->save();

		$appStatusUp = Application::findOrFail(auth()->guard('applicant')->user()->applicantDetail->app_id);
		$appStatusUp->app_status = "pending";

		$appStatusUp->update();
		$applicantDetailUp=ApplicantDetail::findOrFail(auth()->guard('applicant')->user()->applicantDetail->id);
		$applicantDetailUp->app_number='';
		$applicantDetailUp->app_id='';
		$applicantDetailUp->update();

		$follow_up=new FollowUp;
		$follow_up->application_id=$appStatusUp->id;
		$follow_up->app_status=$appStatusUp->app_status;
		$follow_up->status="Application requested";
		$follow_up->updater_role='customer';
		$follow_up->updated_by=auth()->guard('applicant')->user()->name;
		$follow_up->created_date=Carbon::now();
		$follow_up->save();

		if($request->renew_app=="yes"){
			$old_app = Application::findOrFail($request->app_id);
			$old_app->renew = 'renew-applied. New appId:'.$appStatusUp->id;
			$old_app->renew_app_id = $appStatusUp->id;
			$old_app->save();
			$data ="Application Submitted for Renew Successfully!!";
			$renew_flag ="success for renew";
		}else{
			$data ="New Application Submitted Successfully!!";
			$renew_flag ="success renew";
		}

		return (array($data,$renew_flag,$appStatusUp->id));



	}
	public function driverInfoUpdate($app_id, FormValidate $request){
		$this->validate($request, [
			'licence_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'nid_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'org_id_photo' => 'nullable|image|mimes:jpg,jpeg,png'
		]);

		$application = Application::findOrFail($app_id);
        if (Auth::guard('applicant')->user() && $application->retake == 1) {
            $application->retake = 2;
        }
        $application->save();

		$DriverInfo = DriverInfo::findOrFail($application->driverinfo->id);
		if($request->self_driven == '1'){
			if($DriverInfo->driver_is_owner!='1'){
				\File::delete('images/driver_nid/' . basename($DriverInfo->nid_photo));
				$DriverInfo->nid_photo='';
				\File::delete('images/driver_photo/' . basename($DriverInfo->photo));
				$DriverInfo->photo='';
				if($request->hasFile('licence_photo')) {
					\File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));

					$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
					$driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
					$request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
					$DriverInfo->licence_photo = $driver_licence_name;
				}
				$DriverInfo->name ='';
				$DriverInfo->nid_number =null;
				$DriverInfo->address ='';
				$DriverInfo->driver_is_owner='1';
			}else{
				if($request->hasFile('licence_photo')) {
					\File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));
					$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
					$driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
					$request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
					$DriverInfo->licence_photo = $driver_licence_name;
				}
			}
		}
		if($request->self_driven != '1'){
			if($DriverInfo->driver_is_owner=='1'){
				$DriverInfo->driver_is_owner='';
			}
			if($request->hasFile('licence_photo')) {
				\File::delete('images/driver_licence/' . basename($DriverInfo->licence_photo));
				$driver_licence_filename = time() . '.' . $request->licence_photo->getClientOriginalExtension();
				$driver_licence_name = '/images/driver_licence/' . $driver_licence_filename;
				$request->licence_photo->move(public_path('images/driver_licence'), $driver_licence_name);
				$DriverInfo->licence_photo = $driver_licence_name;
			}
			$DriverInfo->name =$request->name;
			$DriverInfo->nid_number = $request->nid_number;
			$present_address = array(
				"flat" => $request->dri_pre_flat,
				"house" => $request->dri_pre_house,
				"road" => $request->dri_pre_road,
				"block" => $request->dri_pre_block,
				"area" => $request->dri_pre_area,
			);
			$permanent_address = array(
				"p_flat" => $request->dri_per_flat,
				"p_house" => $request->dri_per_house,
				"p_road" => $request->dri_per_road,
				"p_block" => $request->dri_per_block,
				"p_area" => $request->dri_per_area,
			);
			$driver_address =array(
				"present" => $present_address,
				"permanent" => $permanent_address,
			);
			$DriverInfo->address =json_encode($driver_address);
			if( $request->hasFile('nid_photo')){
				\File::delete('images/driver_nid/' . basename($DriverInfo->nid_photo));

				$driver_nid_fileName = time() . '.' . $request->nid_photo->getClientOriginalExtension();
				$driver_nid_name = '/images/driver_nid/' . $driver_nid_fileName;
				$request->nid_photo->move(public_path('images/driver_nid'), $driver_nid_name);
				$DriverInfo->nid_photo = $driver_nid_name;
			}
			if($request->hasFile('photo')) {
				\File::delete('images/driver_photo/' . basename($DriverInfo->photo));

				$driver_photo_fileName = time() . '.' . $request->photo->getClientOriginalExtension();
				$driver_photo_name = '/images/driver_photo/' . $driver_photo_fileName;
				$request->photo->move(public_path('images/driver_photo'), $driver_photo_name);
				$DriverInfo->photo = $driver_photo_name;
			}

		}
		$DriverInfo->update();
		$follow_up=new FollowUp;
		$follow_up->application_id=$application->id;
		$follow_up->updater_role=!empty(auth()->guard('applicant')->user()->name)?'customer':auth()->user()->role;
		$follow_up->status="Driver Info Updated";
		$follow_up->created_date=Carbon::now();
		$follow_up->updated_by=!empty(auth()->guard('applicant')->user()->name)?auth()->guard('applicant')->user()->name:auth()->user()->name;
		$follow_up->save();
		$users= User::all();
		foreach ($users as $user) {
			if(!empty(auth()->guard('applicant')->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" => auth()->guard('applicant')->user()->name,
					"action" => "updated driver detail",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			}
			elseif(!empty(auth()->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" =>auth()->user()->name,
					"action" => "updated driver detail",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			}
		}
		$flag ="success";
		$data ="Driver Detail Updated Successfully!";
		return (array($data, $flag));
	}
	public function updateDocument($app_id,FormValidate $request){
		$this->validate($request, [
			'school_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'civil_service_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'job_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'auth_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'ward_com_cert' => 'nullable|image|mimes:jpg,jpeg,png',
			'house_owner_cert' => 'nullable|image|mimes:jpg,jpeg,png',
			'marriage_cert_photo' => 'nullable|image|mimes:jpg,jpeg,png',
			'mother_testm_photo' => 'nullable|image|mimes:jpg,jpeg,png',
		]);
		
		$application = Application::findOrFail($app_id);

        if (Auth::guard('applicant')->user() && $application->retake == 1) {
            $application->retake = 2;
        }


        $application->save();
		$Document = Document::findOrFail($application->document->id);
		if($request->hasFile('school_cert_photo')){

			\File::delete('images/school_cert/' . basename($Document->school_cert));
			$school_cert_name = time() . '.' . $request->school_cert_photo->getClientOriginalExtension();
			$school_cert_file_name ='/images/school_cert/'.$school_cert_name;
			$request->school_cert_photo->move(public_path('images/school_cert'), $school_cert_file_name);
			$Document->school_cert = $school_cert_file_name;
		}
		if($request->hasFile('civil_service_photo')){
			\File::delete('images/civil_service_id/' . basename($Document->civil_service_id));
			$civil_service_id = time() . '.' . $request->civil_service_photo->getClientOriginalExtension();
			$civil_service_idFile ='/images/civil_service_id/'.$civil_service_id;
			$request->civil_service_photo->move(public_path('images/civil_service_id'), $civil_service_idFile);
			$Document->civil_service_id = $civil_service_idFile;
		}
		if($request->hasFile('job_cert_photo')){
			\File::delete('images/job_cert_photo/' . basename($Document->job_cert));
			$job_cert_name = time() . '.'  .  $request->job_cert_photo->getClientOriginalExtension();
			$job_cert_filename ='/images/job_cert_photo/'.$job_cert_name;
			$request->job_cert_photo->move(public_path('images/job_cert_photo'), $job_cert_filename);
			$Document->job_cert = $job_cert_filename;
		}
		if($request->hasFile('auth_cert_photo')){
			\File::delete('images/auth_cert_photo/' . basename($Document->auth_cert));
			$auth_cert_name = time() . '.'  .  $request->auth_cert_photo->getClientOriginalExtension();
			$auth_cert_filename ='/images/auth_cert_photo/'.$auth_cert_name;
			$request->auth_cert_photo->move(public_path('images/auth_cert_photo'), $auth_cert_filename);
			$Document->auth_cert = $auth_cert_filename;
		}
		if($request->hasFile('ward_com_cert')){
			\File::delete('images/ward_com_cert/' . basename($Document->ward_comm_cert));
			$ward_com_certname = time() . '.'  .  $request->ward_com_cert->getClientOriginalExtension();
			$ward_com_certnamefile ='/images/ward_com_cert/'.$ward_com_certname;
			$request->ward_com_cert->move(public_path('images/ward_com_cert'), $ward_com_certnamefile);
			$Document->ward_comm_cert = $ward_com_certnamefile;
		}
		if($request->hasFile('house_owner_cert')){
			\File::delete('images/house_owner_cert/' . basename($Document->house_owner_cert));
			$house_owner_certname = time() . '.'  .  $request->house_owner_cert->getClientOriginalExtension();
			$house_owner_certnamefile ='/images/house_owner_cert/'.$house_owner_certname;
			$request->house_owner_cert->move(public_path('images/house_owner_cert'), $house_owner_certnamefile);
			$Document->house_owner_cert = $house_owner_certnamefile;
		}
		if($request->hasFile('marriage_cert_photo')){
			\File::delete('images/marriage_cert_photo/' . basename($Document->marriage_cert));
			$marriage_cert_photoname = time() . '.'  .  $request->marriage_cert_photo->getClientOriginalExtension();
			$marriage_cert_photonamefile ='/images/marriage_cert_photo/'.$marriage_cert_photoname;
			$request->marriage_cert_photo->move(public_path('images/marriage_cert_photo'), $marriage_cert_photonamefile);
			$Document->marriage_cert = $marriage_cert_photonamefile;
		}
		if($request->hasFile('father_testm_photo')){
			\File::delete('images/father_testm_photo/' . basename($Document->father_testm));
			$father_testm_photoname = time() . '.'  .  $request->father_testm_photo->getClientOriginalExtension();
			$father_testm_photonamefile ='/images/father_testm_photo/'.$father_testm_photoname;
			$request->father_testm_photo->move(public_path('images/father_testm_photo'), $father_testm_photonamefile);
			$Document->father_testm = $father_testm_photonamefile;
		}
		if($request->hasFile('mother_testm_photo')){
			\File::delete('images/mother_testm_photo/' . basename($Document->mother_testm));
			$mother_testm_photoname = time() . '.'  .  $request->mother_testm_photo->getClientOriginalExtension();
			$mother_testm_photonamefile ='/images/mother_testm_photo/'.$mother_testm_photoname;
			$request->mother_testm_photo->move(public_path('images/mother_testm_photo'), $mother_testm_photonamefile);
			$Document->mother_testm = $mother_testm_photonamefile;
		}
		$Document->update();
		$follow_up=new FollowUp;
		$follow_up->application_id=$application->id;
		$follow_up->updater_role=!empty(auth()->guard('applicant')->user()->name)?'customer':auth()->user()->role;
		$follow_up->status="Documents Updated";
		$follow_up->created_date=Carbon::now();
		$follow_up->updated_by=!empty(auth()->guard('applicant')->user()->name)?auth()->guard('applicant')->user()->name:auth()->user()->name;
		$follow_up->save();
		$users= User::all();
		foreach ($users as $user) {
			if(!empty(auth()->guard('applicant')->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" => auth()->guard('applicant')->user()->name,
					"action" => "updated document",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			}
			elseif(!empty(auth()->user()->name)){
				$app_dtail = array(
					"app_number" => $application->app_number,
					"applicant_name" =>auth()->user()->name,
					"action" => "updated document",
				);
				$user->notify(new ApplicationNotification($app_dtail));
			}
		}
		$flag ="success";
		$data ="Document Updated Successfully!";
		return (array($data, $flag));

	}
}
