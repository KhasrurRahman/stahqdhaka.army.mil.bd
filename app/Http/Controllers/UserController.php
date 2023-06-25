<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Hash;
use DB;
use App\StickerCategory;
use App\VehicleType;
use App\ApplicantDetail;
use App\VehicleSticker;
use App\Rank;
use App\Applicant;
use App\VehicleInfo;
use App\Application;
use App\Http\Controllers\HomeController;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
 public function __construct()
 {
  $this->middleware('auth');
} 
public function changePassword(Request $request){
 $user=User::findOrFail(auth()->user()->id);

 if(Hash::check($request->old_password, $user['password']) && $request->password==$request->password_confirmation){
  $user->password=bcrypt($request->password);
  $user->update();
  $successOrFail='success';
  $data = "Password Changed Successfully!";
  return array($data,$successOrFail);
}
else{

 $successOrFail='fail';
 $data = "Password does not matched";
 return array($data,$successOrFail);
}
}
public function clientsList()
{
 $applicants=Applicant::orderBy('created_at','desc')->get();
 return view('layouts.client-lists',compact('applicants'));
}
public function updateClient(Request $req, $clientId)
{
  $client =Applicant::findOrFail($clientId);
  $client->name=$req->name;
  $client->email=$req->email;
  $client->role=$req->client_role;
  $client->phone=$req->phone;
  $client->user_name=$req->user_name;
  $client->update(); 
  $data ="Client has been updated successfully.";
  return array($data,$client);
}
public function DataTableAppsFetch(Request $request)
{
  $allApps=HomeController::allData();
  return Datatables::of($allApps)
  ->addColumn('name_nid', '<a href="application-review/{{$app_number}}" target="_blank">{{$name}}</a> <br> {{$nid_number}}') 
  ->editColumn('address', 'datatables.address')
  ->rawColumns(['name_nid','address'])
  ->toJson();
}
    public function adminSearch(Request $request)
    {
        // return $request->all();
        $reqGlassType='';
        $rank='';
        $vehicle_type1=null;
        $applicant_details=null;
        $applicants=null;
        $vehicles=null;
        $stickers=null;
        $apps=null;
        $allApps=null;
        $glassTypeOptions = [
            'semi-black' => 'Semi-Black',
            'black' => 'Black',
            'transparent' => 'Transparent',
            'normal-transparent' => 'Transparent Normal Glass'
        ];
        $vehicleTypes =VehicleType::all();
        if($request->glass_type!=''){
            $reqGlassType = $glassTypeOptions[$request->glass_type];
        }
        if($request->rank!=''){
            $rank = DB::table('ranks')->where('id', $request->rank)->first();
        }
        if($request->vehicle_type!=''){
            $vehicle_type1=VehicleType::find($request->vehicle_type);
        }
        $stickerTypes=StickerCategory::all();
        $sticker_type=null;

        if ($request->from_date!='') {
            $start = date('Y-m-d',strtotime($request->from_date));
        }
        if ($request->end_date!='') {
            $end = date('Y-m-d',strtotime($request->end_date));
        }


        if($request->name_check == '1' || $request->phone_check=='1' || $request->nid_check=='1' || $request->reg_check=='1'  || $request->sticker_no_check=='1'|| $request->vehicle_type_check=='1'|| $request->from_date_check=='1' || $request->end_date_check=='1' || $request->glass_type_check=='1' || $request->BA_check=='1'  || $request->rank_check=='1'|| $request->house_check=='1'|| $request->road_check=='1'|| $request->area_check=='1'|| $request->year_check=='1' || $request->sticker_type_check=='1' )
        {
            if ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date == '' && $request->end_date=='' && $request->phone!='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year=='' && $request->sticker_type=='') {
                $applicants = Applicant::where( 'phone', $request->phone)->get();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date == '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name!='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {
                $applicants = Applicant::where('name', 'LIKE',  '%' . $request->name . '%')->get();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date == '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no!='' && $request->year==''  && $request->sticker_type=='') {
                $stickers = VehicleSticker::where('sticker_number', $request->sticker_no)->first();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date == '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number!='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {
                $applicant_details = ApplicantDetail::where('nid_number', $request->nid_number)->get();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date == '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type!='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $apps = Application::where('vehicle_type_id', $request->vehicle_type)->where('app_status','!=','processing')->get();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date == '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type!=''){
                $apps = Application::where('sticker_category', $request->sticker_type)->where('app_status','!=','processing')->get();
                $sticker_type=StickerCategory::where('value',$request->sticker_type)->first();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date!= '' && $request->end_date!='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type!=''){
                $apps = Application::where('sticker_category', $request->sticker_type)->whereBetween('app_date', [$start, $end])->where('app_status','!=','processing')->get();
                $sticker_type=StickerCategory::where('value',$request->sticker_type)->first();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date!= '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type!=''){
                $apps = Application::where('sticker_category', $request->sticker_type)->whereDate('app_date',$start)->where('app_status','!=','processing')->get();
                $sticker_type=StickerCategory::where('value',$request->sticker_type)->first();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date== '' && $request->end_date!='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type!=''){
                $apps = Application::where('sticker_category', $request->sticker_type)->whereDate('app_date', $end)->where('app_status','!=','processing')->get();
                $sticker_type=StickerCategory::where('value',$request->sticker_type)->first();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no=='' && $request->from_date== '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year!=''  && $request->sticker_type!=''){
                $apps = Application::where('sticker_category', $request->sticker_type)->whereYear('app_date', $request->year)->where('app_status','!=','processing')->get();
                $sticker_type=StickerCategory::where('value',$request->sticker_type)->first();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->reg_no!='' && $request->from_date == '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {
                $vehicles = VehicleInfo::where('reg_number', 'LIKE',  '%' . $request->reg_no . '%' )->get();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->from_date != '' && $request->end_date!='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type==''){
                $apps= Application::whereBetween('app_date', [$start, $end])->where('app_status','!=','processing')->get();
            }
            elseif($request->house=='' && $request->road=='' && $request->area=='' && $request->from_date != '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type==''){
                $apps= Application::whereDate('app_date', $start)->where('app_status','!=','processing')->get();
            }
            elseif($request->house=='' && $request->road=='' && $request->area=='' && $request->from_date == '' && $request->end_date!='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type==''){
                $apps= Application::whereDate('app_date' , $end)->where('app_status','!=','processing')->get();
            }
            elseif($request->house=='' && $request->road=='' && $request->area=='' && $request->from_date == '' && $request->end_date=='' && $request->phone=='' && $request->glass_type=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year!=''){
                $apps= Application::whereYear('app_date' , $request->year)->where('app_status','!=','processing')->get();
            }

            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->phone=='' && $request->glass_type!='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $vehicles = VehicleInfo::where('glass_type','=',$request->glass_type)->get();

            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA!='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('applicant_BA_no', 'LIKE',  '%' . $request->BA . '%' )->get();
            }
            elseif ($request->house=='' && $request->road=='' && $request->area=='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank!='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('rank_id',  $request->rank)->get();

            }
            elseif ($request->house!='' && $request->road=='' && $request->area==''  && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('address->present->house','LIKE',  '%' . $request->house . '%')->get();


            }
            elseif ($request->house=='' && $request->road!='' && $request->area=='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('address->present->road','LIKE',  '%' . $request->road . '%')->get();


            }
            elseif ($request->house=='' && $request->road=='' && $request->area!='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('address->present->area','LIKE',  '%' . $request->area . '%')->get();


            }
            elseif ($request->house=='' && $request->road!='' && $request->area!='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('address->present->area','LIKE',  '%' . $request->area . '%')->where('address->present->road','LIKE',  '%' . $request->road . '%')->get();


            }
            elseif ($request->house!='' && $request->road=='' && $request->area!='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('address->present->area','LIKE',  '%' . $request->area . '%')->where('address->present->house','LIKE',  '%' . $request->house . '%')->get();


            }
            elseif ($request->house!='' && $request->road!='' && $request->area=='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('address->present->road','LIKE',  '%' . $request->road . '%')->where('address->present->house','LIKE',  '%' . $request->house . '%')->get();
            }
            elseif ($request->house!='' && $request->road!='' && $request->area!='' && $request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {

                $applicant_details = ApplicantDetail::where('address->present->house','LIKE',  '%' . $request->house . '%')->where('address->present->area','LIKE',  '%' . $request->area . '%')->where('address->present->road','LIKE',  '%' . $request->road . '%')->get();


            }
            elseif ($request->phone=='' && $request->glass_type=='' && $request->from_date!='' && $request->end_date!='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type!='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {
                $allApps = DB::table('applications')
                    ->where('app_status', '!=', 'processing')
                    ->where('applications.vehicle_type_id', '=', $request->vehicle_type)
                    ->whereBetween('applications.app_date', [$start, $end])
                    ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                    ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                    ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applications.applicant_id')
                    ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                    ->leftJoin('vehicle_stickers', 'vehicle_stickers.application_id', '=', 'applications.id')
                    ->select(
                        'applications.app_number',
                        'applications.app_status',
                        'applications.app_date',
                        'applications.glass_type',
                        'applications.type',
                        'applications.sticker_category',
                        'applicants.name',
                        'applicants.phone',
                        'applicant_details.address',
                        'applicant_details.nid_number',
                        'applicant_details.applicant_BA_no',
                        'applicant_details.rank_id',
                        'vehicle_infos.reg_number',
                        'vehicle_types.name as vehicleTypeName',
                        'vehicle_stickers.sticker_number'
                    )
                    ->get();

            }
            elseif ($request->phone=='' && $request->glass_type=='' && $request->from_date!='' && $request->end_date!='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type!='') {
                $allApps = DB::table('applications')
                    ->where('app_status', '!=', 'processing')
                    ->where('applications.sticker_category', '=', $request->sticker_type)
                    ->whereBetween('applications.app_date', [$start, $end])
                    ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                    ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                    ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applications.applicant_id')
                    ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                    ->leftJoin('vehicle_stickers', 'vehicle_stickers.application_id', '=', 'applications.id')
                    ->select(
                        'applications.app_number',
                        'applications.app_status',
                        'applications.app_date',
                        'applications.glass_type',
                        'applications.type',
                        'applications.sticker_category',
                        'applicants.name',
                        'applicants.phone',
                        'applicant_details.address',
                        'applicant_details.nid_number',
                        'applicant_details.applicant_BA_no',
                        'applicant_details.rank_id',
                        'vehicle_infos.reg_number',
                        'vehicle_types.name as vehicleTypeName',
                        'vehicle_stickers.sticker_number'
                    )
                    ->get();

            }

            elseif ($request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank=='' && $request->sticker_no=='' && $request->year!=''  && $request->sticker_type!='') {
                $allApps = DB::table('applications')
                    ->where('app_status', '!=', 'processing')
                    ->whereYear('applications.app_date', $request->year)
                    ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                    ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                    ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applications.applicant_id')
                    ->where('applicant_details.rank_id', '=', $request->sticker_type)
                    ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                    ->leftJoin('vehicle_stickers', 'vehicle_stickers.application_id', '=', 'applications.id')
                    ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                    ->select(
                        'applications.app_number',
                        'applications.app_status',
                        'applications.app_date',
                        'applications.glass_type',
                        'applications.type',
                        'applications.sticker_category',
                        'applicants.name',
                        'applicants.phone',
                        'applicant_details.address',
                        'applicant_details.nid_number',
                        'applicant_details.applicant_BA_no',
                        'ranks.name as rankName',
                        'vehicle_infos.reg_number',
                        'vehicle_types.name as vehicleTypeName',
                        'vehicle_stickers.sticker_number'
                    )
                    ->get();

            }
            elseif ($request->phone=='' && $request->glass_type=='' && $request->from_date!='' && $request->end_date!='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank!='' && $request->sticker_no=='' && $request->year==''  && $request->sticker_type=='') {
                $allApps = DB::table('applications')
                    ->where('app_status', '!=', 'processing')
                    ->whereBetween('applications.app_date', [$start, $end])
                    ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                    ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                    ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applications.applicant_id')
                    ->where('applicant_details.rank_id', '=', $request->rank)
                    ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                    ->leftJoin('vehicle_stickers', 'vehicle_stickers.application_id', '=', 'applications.id')
                    ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                    ->select(
                        'applications.app_number',
                        'applications.app_status',
                        'applications.app_date',
                        'applications.glass_type',
                        'applications.type',
                        'applications.sticker_category',
                        'applicants.name',
                        'applicants.phone',
                        'applicant_details.address',
                        'applicant_details.nid_number',
                        'applicant_details.applicant_BA_no',
                        'ranks.name as rankName',
                        'vehicle_infos.reg_number',
                        'vehicle_types.name as vehicleTypeName',
                        'vehicle_stickers.sticker_number'
                    )
                    ->get();

            }
            elseif ($request->phone=='' && $request->glass_type=='' && $request->from_date=='' && $request->end_date=='' && $request->name=='' && $request->reg_no=='' && $request->vehicle_type=='' && $request->nid_number=='' && $request->BA=='' && $request->rank!='' && $request->sticker_no=='' && $request->year!=''  && $request->sticker_type=='') {
                $allApps = DB::table('applications')
                    ->where('app_status', '!=', 'processing')
                    ->whereYear('applications.app_date', $request->year)
                    ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                    ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                    ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applications.applicant_id')
                    ->where('applicant_details.rank_id', '=', $request->rank)
                    ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                    ->leftJoin('vehicle_stickers', 'vehicle_stickers.application_id', '=', 'applications.id')
                    ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                    ->select(
                        'applications.app_number',
                        'applications.app_status',
                        'applications.app_date',
                        'applications.glass_type',
                        'applications.type',
                        'applications.sticker_category',
                        'applicants.name',
                        'applicants.phone',
                        'applicant_details.address',
                        'applicant_details.nid_number',
                        'applicant_details.applicant_BA_no',
                        'ranks.name as rankName',
                        'vehicle_infos.reg_number',
                        'vehicle_types.name as vehicleTypeName',
                        'vehicle_stickers.sticker_number'
                    )
                    ->get();

            }

            return view('home')->with('applicants', $applicants)->with('applicant_details', $applicant_details)->with('vehicles', $vehicles)->with('apps', $apps)->with('date_to', $request->end_date)->with('date_from', $request->from_date)->with('applicant_name', $request->name)->with('vehicle_type', $vehicle_type1)->with('applicant_phone', $request->phone)->with('applicant_nid_number', $request->nid_number)->with('reg_no', $request->reg_no)->with('vehicleTypes', $vehicleTypes)->with('glass_type', $reqGlassType)->with('glass_type_val', $request->glass_type)->with('applicant_BA',$request->BA)->with('applicant_Rank', $rank)->with('stickers', $stickers)->with('sticker_no', $request->sticker_no)->with('house', $request->house)->with('road', $request->road)->with('area', $request->area)->with('year', $request->year)->with('sticker_type', $sticker_type)->with('stickerTypes', $stickerTypes)->with('allApps', $allApps);
        }
        elseif($applicants=='' && $applicant_details=='' && $vehicles=='' && $apps=='' && $stickers==''){
            $message = "No Application Found As Given Information";
            return view('home',compact('message'));
        }
    }

}
