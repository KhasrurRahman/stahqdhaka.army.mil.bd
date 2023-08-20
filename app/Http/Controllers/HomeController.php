<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\ApplicantDetail;
use App\Application;
use App\ApplicationNotify;
use App\BankDeposit;
use App\FollowUp;
use App\Invoice;
use App\Jobs\SendSMSandMail;
use App\Jobs\SendMail;
use App\Mail\IssuedMail;
use App\Mail\NotifyApplicant;
use App\Mail\notifyApproveMail;
use App\Mail\notifyRejectMail;
use App\Rank;
use App\Sms;
use App\SmsApplicant;
use App\SpouseParentsUnit;
use App\StickerCategory;
use App\User;
use App\VehicleInfo;
use App\VehicleSticker;
use App\VehicleType;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Session;
use Yajra\Datatables\Datatables;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */



    public function DataTableClientFetch(Request $request){
        DB::statement(DB::raw('set @rownum=0'));
        $applicant=Applicant::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'user_name',
            'email',
            'phone',
            'role',
            'created_at',
            'updated_at']);
        return Datatables::of($applicant)
            ->setRowId(function ($applicant) {
                return 'client-'. $applicant->id;
            })
            // ->addColumn('action', 'datatables.client')
            ->addColumn('action', function(Applicant $applicant) {
                return '<button class="btn btn-info edit-client" data-name="'.$applicant->name.'" data-email="'.$applicant->email.'" data-role="'.$applicant->role.'" data-phone="'.$applicant->phone.'" data-uname="'.$applicant->user_name.'" data-id="'.$applicant->id.'" data-toggle="modal" data-target="#edit_client_modal"><i class="fas fa-edit"></i></button>';
            })
            ->make(true);

    }

    public static function allData(){
        DB::statement(DB::raw('set @rownum=0'));
        return DB::table('applications')
            ->where('app_status', '!=', 'processing')
            ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
            ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
            ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applications.applicant_id')
            ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
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
                'ranks.name as rankName',
                'vehicle_infos.reg_number',
                'vehicle_types.name as vehicleTypeName',
                'vehicle_stickers.sticker_number',
                DB::raw('@rownum  := @rownum  + 1 AS rownum')
            )
            ->orderBy('applications.created_at', 'DESC')
            ->get();
    }

    public function index()
    {
        $vehicleTypes =VehicleType::all();
        $stickerTypes =StickerCategory::all();

        $applicant_name = request('name')??"";
        $applicant_BA = request('BA') ?? "";
        $applicant_Rank = request('rank') ?? "";
        $glass_type = request('glass_type') ?? "";
        $applicant_phone = request('phone') ?? "";
        $reg_no = request('reg_no') ?? "";
        $applicant_nid_number = request('nid_number') ?? "";
        $sticker_no = request('sticker_no') ?? "";
        $sticker_type = request('sticker_type') ?? "";
        $vehicle_type = request('vehicle_type') ?? "";
        $house = request('house') ?? "";
        $road = request('road') ?? "";
        $area = request('area') ?? "";
        $date_from = request('from_date') ?? "";
        $date_to = request('end_date') ?? "";
        $year = request('year') ?? "";
        return view('home',compact('vehicleTypes','stickerTypes','applicant_name','applicant_BA','applicant_Rank','glass_type','applicant_phone',
            'reg_no','applicant_nid_number','sticker_no','sticker_type','vehicle_type','house','road','area','date_from','date_to','year'));
    }

    public function allAppsDatatable(Request $request)
    {

        $query = Application::with('applicant', 'vehicleinfo', 'applicationNotify');
        // $sticker_category = $request->sticker_category;
        // $from_date = request('inspec_from_date') ? date('Y-m-d', strtotime(request('inspec_from_date'))) : '';
        // $to_date = request('inspec_to_date') ? date('Y-m-d', strtotime(request('inspec_to_date'))) : '';

        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name','like', '%'.$request->applicant_name.'%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->applicant_BA) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no','like', '%'.$request->applicant_BA.'%' )->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->applicant_Rank) {
            $applicant_ids = ApplicantDetail::where('rank_id',$request->applicant_Rank)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->applicant_nid_number) {
            $applicant_ids = ApplicantDetail::where('nid_number', 'like', '%'.$request->applicant_nid_number.'%' )->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->applicant_phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%'.$request->applicant_phone.'%' )->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }
        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->sticker_no) {
            $applicant_ids = VehicleSticker::where('sticker_number', 'like', '%'.$request->sticker_no.'%' )->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->glass_type) {
            $query->where('glass_type',$request->glass_type);
        }

        if ($request->sticker_type) {
            $query->where('sticker_category', 'like', '%'.$request->sticker_type.'%' );
        }

        if ($request->vehicle_type) {
            $query->where('vehicle_type_id', 'like', '%'.$request->vehicle_type.'%' );
        }

        if ($request->year) {
            $query->whereYear('app_date', $request->year);
        }

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('app_date', [$request->date_from, $request->date_to]);
        }

        // if ($from_date && $to_date) {
        //     $query->whereBetween('app_date', [$from_date, $to_date]);
        // }
        return DataTables::of($query)
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->filterColumn('app_date', function ($query, $keyword) {
                $query->whereDate('app_date', date('Y-m-d', strtotime($keyword)));
            })
            ->addColumn('sticker_number', function (Application $application) {
                return $application->vehicleSticker->sticker_number??'';
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {
                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->addColumn('app_status', function (Application $application) {
                $app_status = ($application->app_status == 'forwarded to PS') ? "Forwarded  To MP DTE" : $application->app_status;
                return $app_status;
            })
            ->rawColumns(['applicant_name', 'BA_no', 'Rank_id', 'phone_number', 'sticker_number', 'vehicleType', 'address','app_status'])
            ->toJson();
    }

    public function allapps()
    {
        $allApps=$this->allData();
        $vehicleTypes =VehicleType::all();
        $stickerTypes =StickerCategory::all();
        return view('home',compact('allApps','vehicleTypes','stickerTypes'));
    }

    // public function pendingApp($def){
    //   if($def=='def'){
    //     $apps = Application::where('app_status','pending')->where('type','=','def')->orderBy('created_at','desc')->get();
    //   }elseif($def=='non-def'){
    //     $apps = Application::where('app_status','pending')->where('type','=','non-def')->orderBy('created_at','desc')->get();
    //   }elseif($def=='not-transparent'){
    //     $apps = Application::where('app_status','pending')->where('glass_type','!=','transparent')->orderBy('created_at','desc')->get();
    //   }elseif($def=='transparent'){
    //     $apps = Application::where('app_status','pending')->where('glass_type','=','transparent')->orderBy('created_at','desc')->get();
    //   }
    //   return view('apps.pending',compact('apps'));
    // }
    public function pendingApp(Request $request,$def)
    {
        $applicant_name = $request->applicant_name??"";
        $ba = $request->ba??"";
        $rank = $request->rank??"";
        $reg_no = $request->reg_no??"";
        $phone = $request->phone??"";
        $date = $request->date??"";
        $Vehicle_Type = $request->Vehicle_Type??"";
        $present_address = $request->present_address??"";


        return view('apps.pending', compact('def', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone','date', 'Vehicle_Type', 'present_address'));
    }

    public function holdingApp(Request $request,$def)
    {
        $applicant_name = $request->applicant_name??"";
        $ba = $request->ba??"";
        $rank = $request->rank??"";
        $reg_no = $request->reg_no??"";
        $phone = $request->phone??"";
        $date = $request->date??"";
        $Vehicle_Type = $request->Vehicle_Type??"";
        $present_address = $request->present_address??"";


        return view('apps.holding', compact('def', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone','date', 'Vehicle_Type', 'present_address'));
    }


    public function retakeApp(Request $request,$def)
    {
        $applicant_name = $request->applicant_name??"";
        $ba = $request->ba??"";
        $rank = $request->rank??"";
        $reg_no = $request->reg_no??"";
        $phone = $request->phone??"";
        $date = $request->date??"";
        $Vehicle_Type = $request->Vehicle_Type??"";
        $present_address = $request->present_address??"";
        return view('apps.retake', compact('def', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone','date', 'Vehicle_Type', 'present_address'));
    }

    public function allPendingDatatable(Request $request)
    {
        $def = request('def');
        $query = Application::with('applicant', 'vehicleinfo', 'VehicleSticker', 'applicant.applicantDetail', 'vehicleinfo.vehicleType', 'applicant.applicantDetail.rank')->where('app_status', 'pending');

        if ($def == 'def') {
            $query->where('type', '=', 'def');
        }
        if ($def == 'non-def') {
            $query->where('type', '=', 'non-def');
        }
        if ($def == 'not-transparent') {
            $query->where('glass_type', '!=', 'transparent');
        }
        if ($def == 'transparent') {
            $query->where('glass_type', '=', 'transparent');
        }

        // Search Data 
        if($request->applicant_name){
            $applicant_ids = Applicant::where('name','like', '%'.$request->applicant_name.'%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->phone){
            $applicant_ids = Applicant::where('phone','like', '%'.$request->phone.'%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->ba){
            $applicant_ids = ApplicantDetail::where('applicant_BA_no','like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->rank){
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->present_address){
            $applicant_ids = ApplicantDetail::where('address','like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $query->where('app_date', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }


        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no =  $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->filterColumn('app_date', function ($query, $keyword) {
                $query->whereDate('app_date', date('Y-m-d', strtotime($keyword)));
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {

                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function allHoldingDatatable(Request $request)
    {
        $def = request('def');
        $query = Application::with('applicant', 'vehicleinfo', 'VehicleSticker', 'applicant.applicantDetail', 'vehicleinfo.vehicleType', 'applicant.applicantDetail.rank')->where('app_status', 'hold');

        if ($def == 'def') {
            $query->where('type', '=', 'def');
        }
        if ($def == 'non-def') {
            $query->where('type', '=', 'non-def');
        }
        if ($def == 'not-transparent') {
            $query->where('glass_type', '!=', 'transparent');
        }
        if ($def == 'transparent') {
            $query->where('glass_type', '=', 'transparent');
        }

        // Search Data
        if($request->applicant_name){
            $applicant_ids = Applicant::where('name','like', '%'.$request->applicant_name.'%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->phone){
            $applicant_ids = Applicant::where('phone','like', '%'.$request->phone.'%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->ba){
            $applicant_ids = ApplicantDetail::where('applicant_BA_no','like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->rank){
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->present_address){
            $applicant_ids = ApplicantDetail::where('address','like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $query->where('app_date', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }


        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no =  $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->filterColumn('app_date', function ($query, $keyword) {
                $query->whereDate('app_date', date('Y-m-d', strtotime($keyword)));
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {

                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function allRetakeDatatable(Request $request)
    {
        $def = request('def');
        $query = Application::with('applicant', 'vehicleinfo', 'VehicleSticker', 'applicant.applicantDetail', 'vehicleinfo.vehicleType', 'applicant.applicantDetail.rank')
            ->where('app_status','updated')
            ->where('retake',2);

        if ($def == 'def') {
            $query->where('type', '=', 'def');
        }
        if ($def == 'non-def') {
            $query->where('type', '=', 'non-def');
        }
        if ($def == 'not-transparent') {
            $query->where('glass_type', '!=', 'transparent');
        }
        if ($def == 'transparent') {
            $query->where('glass_type', '=', 'transparent');
        }

        // Search Data
        if($request->applicant_name){
            $applicant_ids = Applicant::where('name','like', '%'.$request->applicant_name.'%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->phone){
            $applicant_ids = Applicant::where('phone','like', '%'.$request->phone.'%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->ba){
            $applicant_ids = ApplicantDetail::where('applicant_BA_no','like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->rank){
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if($request->present_address){
            $applicant_ids = ApplicantDetail::where('address','like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $query->where('app_date', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }


        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no =  $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->filterColumn('app_date', function ($query, $keyword) {
                $query->whereDate('app_date', date('Y-m-d', strtotime($keyword)));
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {

                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function approvedApp(Request $request, $def){
        $stickerTypes = StickerCategory::all();
        $applicant_name = $request->applicant_name ?? "";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $date = $request->date ?? "";
        $Vehicle_Type = $request->Vehicle_Type ?? "";
        $glass_type = $request->Vehicle_Type ?? "";
        $sticker_type = $request->sticker_type ?? "";
        $present_address = $request->present_address ?? "";
        return view('apps.approved', compact('stickerTypes', 'def', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone', 'date', 'Vehicle_Type', 'glass_type', 'sticker_type', 'present_address'));
    }

    public function allApprovedDatatable(Request $request)
    {
        $def = request('def');
        $query = Application::with(['applicant', 'vehicleinfo', 'vehicleinfo.vehicleType'])->whereIn('app_status', ['approved', 'PS approved']);

        if ($def == 'def') {
            $query->where('type', '=', 'def');
        }
        if ($def == 'non-def') {
            $query->where('type', '=', 'non-def');
        }
        if ($def == 'not-transparent') {
            $query->where('glass_type', '!=', 'transparent');
        }
        if ($def == 'transparent') {
            $query->where('glass_type', '=', 'transparent');
        }

        // Search Data 
        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->rank) {
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $query->where('app_date', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }

        // if ($request->glass_type) {
        //     $query->where('glass_type', $request->glass_type);
        // }

        if ($request->sticker_type) {
            $query->where('sticker_category', $request->sticker_type);
        }


        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = ($application->vehicleinfo) ? $application->vehicleinfo->reg_number : '';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->filterColumn('app_date', function ($query, $keyword) {
                $query->whereDate('app_date', date('Y-m-d', strtotime($keyword)));
            })
            ->filterColumn('app_date', function ($query, $keyword) {
                $query->whereDate('app_date', date('Y-m-d', strtotime($keyword)));
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type =
                    $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {

                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function rejectedApp(Request $request, $def){
        $stickerTypes = StickerCategory::all();
        $glass_type = $request->Vehicle_Type ?? "";
        $sticker_type = $request->sticker_type ?? "";
        $applicant_name = $request->applicant_name ?? "";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $date = $request->date ?? "";
        $Vehicle_Type = $request->Vehicle_Type ?? "";
        $present_address = $request->present_address ?? "";
        return view('apps.rejected', compact('def', 'stickerTypes', 'glass_type', 'sticker_type', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone', 'date', 'Vehicle_Type', 'present_address'));
    }

    public function allRejectedDatatable(Request $request)
    {
        $def = request('def');
        $query = Application::with('applicant', 'vehicleinfo', 'vehicleSticker')->where('app_status','updated')->where('retake',1);

        if ($def == 'def') {
            $query->where('type', '=', 'def');
        }

        if ($def == 'non-def') {
            $query->where('type', '=', 'non-def');
        }

        if ($def == 'not-transparent') {
            $query->where('glass_type', '!=', 'transparent');
        }

        if ($def == 'transparent') {
            $query->where('glass_type', '=', 'transparent');
        }

        // Search Data 
        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->rank) {
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $query->where('app_date', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }
        if ($request->glass_type) {
            $query->where('glass_type', $request->glass_type);
        }

        if ($request->sticker_type) {
            $query->where('sticker_category', $request->sticker_type);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name ?? '';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->filterColumn('app_date', function ($query, $keyword) {
                $query->whereDate('app_date', date('Y-m-d', strtotime($keyword)));
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {

                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function deliveredApp(Request $request,$def){
        $stickerTypes = StickerCategory::all();
        $glass_type = $request->Vehicle_Type ?? "";
        $sticker_type = $request->sticker_type ?? "";
        $applicant_name = $request->applicant_name ?? "";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $date = $request->date ?? "";
        $Vehicle_Type = $request->Vehicle_Type ?? "";
        $present_address = $request->present_address ?? "";
        return view('apps.delivered', compact('def', 'stickerTypes', 'glass_type', 'glass_type', 'sticker_type', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone', 'date', 'Vehicle_Type', 'present_address'));
    }

    public function allDeleveredDatatable(Request $request)
    {
        $def = request('def');
        $query = Application::with(['applicant', 'vehicleinfo', 'vehicleinfo.vehicleType', 'vehicleSticker', 'applicant.applicantDetail', 'applicant.applicantDetail.rank'])->where('app_status', 'issued');

        if ($def == 'def') {
            $query->where('type', '=', 'def');
        }

        if ($def == 'non-def') {
            $query->where('type', '=', 'non-def');
        }

        if ($def == 'not-transparent') {
            $query->where('glass_type', '!=', 'transparent');
        }

        if ($def == 'transparent') {
            $query->where('glass_type', '=', 'transparent');
        }

        // Search Data 
        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->rank) {
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $applicaation_ids = ApplicationNotify::whereDate('sticker_delivery_date', date('Y-m-d', strtotime($request->date)))->pluck('application_id');
            $query->whereIn('id', $applicaation_ids);
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }

        if ($request->sticker_type) {
            $query->where('sticker_category', $request->sticker_type);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = $application->applicant->applicantDetail->applicant_BA_no??'';
                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->addColumn('exp_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->vehicleSticker->exp_date??''));
            })
            ->filterColumn('exp_date', function ($query, $keyword) {
                $application_ids = VehicleSticker::whereDate('exp_date', date('Y-m-d', strtotime($keyword)))->pluck('application_id');
                $query->whereIn('id', $application_ids);
            })

            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('vehicleSticker_sticker_number', function (Application $application) {
                $vehicleSticker_sticker_number = $application->vehicleSticker->sticker_number??'';
                return $vehicleSticker_sticker_number;
            })
            ->addColumn('address', function (Application $application) {
                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function expiredSticker(Request $request, $def){
        $stickerTypes = StickerCategory::all();
        $glass_type = $request->Vehicle_Type ?? "";
        $sticker_type = $request->sticker_type ?? "";
        $applicant_name = $request->applicant_name ?? "";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $date = $request->date ?? "";
        $Vehicle_Type = $request->Vehicle_Type ?? "";
        $present_address = $request->present_address ?? "";
        return view('apps.expired', compact('def', 'stickerTypes', 'glass_type', 'sticker_type', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone', 'date', 'Vehicle_Type', 'present_address'));
    }

    public function allExpiredDatatable(Request $request)
    {
        $def = request('def');
        $query = Application::with(['applicant', 'vehicleinfo', 'vehicleinfo.vehicleType', 'vehicleSticker', 'applicant.applicantDetail', 'applicant.applicantDetail.rank'])->where('app_status', 'expired');

        if ($def == 'def') {
            $query->where('type', '=', 'def');
        }
        if ($def == 'non-def') {
            $query->where('type', '=', 'non-def');
        }
        if ($def == 'not-transparent') {
            $query->where('glass_type', '!=', 'transparent');
        }
        if ($def == 'transparent') {
            $query->where('glass_type', '=', 'transparent');
        }

        // Search Data 
        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->rank) {
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $application_ids = VehicleSticker::whereDate('exp_date', date('Y-m-d', strtotime($request->date)))->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }
        // if ($request->glass_type) {
        //     $query->where('glass_type', $request->glass_type);
        // }

        if ($request->sticker_type) {
            $query->where('sticker_category', $request->sticker_type);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->addColumn('exp_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->vehicleSticker->exp_date??''));
            })
            ->filterColumn('exp_date', function ($query, $keyword) {
                $application_ids = VehicleSticker::whereDate('exp_date', date('Y-m-d', strtotime($keyword)))->pluck('application_id');
                $query->whereIn('id', $application_ids);
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {

                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function applicationForwardedList(Request $request){
        $forwarded_from_date = $request->forwarded_from_date??'';
        $forwarded_to_date = $request->forwarded_to_date??'';

        $stickerTypes = StickerCategory::all();
        $applicant_name = $request->applicant_name ?? "";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $date = $request->date ?? "";
        $Vehicle_Type = $request->Vehicle_Type ?? "";
        $present_address = $request->present_address ?? "";

        return view('apps.forwarded', compact('forwarded_from_date','forwarded_to_date', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone', 'date', 'Vehicle_Type', 'present_address'));
    }


    public function forwardedAppsDatatable(Request $request)
    {
        $query = Application::with('applicant', 'vehicleinfo')->where('app_status', 'forwarded to PS');
        $forwarded_from_date = date('Y-m-d', strtotime($request->forwarded_from_date));
        $forwarded_to_date = date('Y-m-d', strtotime($request->forwarded_to_date));

        // Search Data 
        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->rank) {
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $query->where('app_date', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }

        if ($request->forwarded_from_date && $request->forwarded_to_date) {
            $query->whereBetween('app_date', [$forwarded_from_date, $forwarded_to_date]);
        }


        return DataTables::of($query)
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->rank_id : '';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = ($application->vehicleinfo) ? $application->vehicleinfo->reg_number : '';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = ($application->vehicleinfo->vehicleType) ? $application->vehicleinfo->vehicleType->name : '';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {

                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                if($app_address){
                    return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
                }

            })
            ->rawColumns(['applicant_name'])
            ->toJson();
    }

    public function applicationReview($app_number){
        $app = Application::where('app_number',$app_number)->first();


        $stickerPrice=null;
        $stickerCategory=StickerCategory::where('value',$app->sticker_category)->first();
        if(!empty($stickerCategory)) {
            if ($stickerCategory->hasMultiVehicleType == 1) {
              $stickerPrice = DB::SELECT("SELECT vehicle_type_wise_sticker_price.price FROM vehicle_type_wise_sticker_price,sticker_categories WHERE sticker_categories.id=sticker_categorie_id AND sticker_categories.value='" . $app->sticker_category . "' AND vehicle_type_id='" . $app->vehicleinfo->vehicle_type_id . "'");
              if(!empty($stickerPrice)){
                  $stickerPrice =$stickerPrice[0]->price;
              }else{
                  $stickerPrice =0;
              }


            } else {



                $stickerPrice = $stickerCategory->price;
            }
        }

        $all_sms=Sms::where('type','manual')->get();
     
        return view('apps.review',compact('app','all_sms','stickerPrice'));
    }
    public function applicationRevewFromNotification($app_number,$not_id){
        $app = Application::where('app_number',$app_number)->first();
        $user = \Auth::user();
        $all_sms=Sms::where('type','manual')->get();
        $notification = $user->notifications()->where('id',$not_id)->first();
        if ($notification) {

            $notification->markAsRead();
            // auth()->user()->unreadNotifications->markAsRead();

        }else{
            return view('apps.review',compact('app','all_sms'));
        }
        return view('apps.review',compact('app','all_sms'));
    }


    public function applicationApprove(Request $request)
    {

        $final_approveSms = '';
        $mail_status = '';
        $sms_sent = '';
        $app = Application::where('app_number', $request->app_num)->first();
        $appnotifyexist = ApplicationNotify::where('application_id', $app->id)->first();
        //start_newapproved_msg
        $sticker_category = StickerCategory::where('name', $request->sticker_type)->first();
        //end_newapproved_msg
        if ($app->app_status == "pending" || $app->app_status == "updated" && $app->retake == 2 || $app->app_status == "forwarded to PS") {
            $approveAppCount = DB::table('applications')
                ->where(function ($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('application_notifies', 'application_notifies.application_id', '=', 'applications.id')
                ->whereDate('application_notifies.sticker_delivery_date', '=', $request->sticker_delivery_date)
                ->count();
            $time = '';
            $app_per_slot = 20;
            $slotFactor = $approveAppCount / $app_per_slot;
            $no_free_slot = '';
            if ($slotFactor <= 1) {
                $time = '10.00 AM';
            } elseif (1 < $slotFactor && $slotFactor <= 2) {
                $time = '10.30 AM';
            } elseif (2 < $slotFactor && $slotFactor <= 3) {
                $time = '11.00 AM';
            } elseif (3 < $slotFactor && $slotFactor <= 4) {
                $time = '11.30 AM';
            } elseif (4 < $slotFactor && $slotFactor <= 5) {
                $time = '12.00 PM';
            } elseif (5 < $slotFactor && $slotFactor <= 6) {
                $time = '12.30 PM';
            } elseif (6 < $slotFactor && $slotFactor <= 7) {
                $time = '01.00 PM';
            } elseif (7 < $slotFactor && $slotFactor <= 8) {
                $time = '01.30 PM';
            } else {
                $no_free_slot = "No space available in any delivery time slot on " . $request->sticker_delivery_date;
                return json_encode(array('no slot available', $no_free_slot));
            }
            if ($app->app_status == "forwarded to PS")
                $app->ps_approved = 1;

            $app->app_status = $app->app_status == "forwarded to PS" ? "PS approved" : "approved";
            $app->sticker_category = $request->sticker_type;
            $app->retake = 1;
            $app->save();

            if (!$appnotifyexist) {
                $ApplicationNotify = new ApplicationNotify;
                $ApplicationNotify->application_id = $app->id;
                $ApplicationNotify->applicant_phone = $app->applicant->phone;
                $ApplicationNotify->app_status = $app->app_status;
                $ApplicationNotify->sticker_delivery_date = $request->sticker_delivery_date;
                $ApplicationNotify->save();
            } else {
                $appnotifyexist->app_status = $app->app_status;
                $appnotifyexist->sticker_delivery_date = $request->sticker_delivery_date;
                $appnotifyexist->mis_matched = Null;
                $appnotifyexist->custom_reject_sms = Null;
                $appnotifyexist->save();
            }
            
            $sms = Sms::where('type', '=', 'approved')->first();
            $url_link = route('payment.view', encrypt($app->id));
            $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
            $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $banglaDate = str_replace($en, $bn, $request->sticker_delivery_date);
            $banglaTime = str_replace($en, $bn, $time);
            $banglaRegNumber = str_replace($en, $bn, $app->vehicleinfo->reg_number);
            $dateApplicationNotify = date('d-m-Y', strtotime($request->sticker_delivery_date));
            $approveSms = str_replace('//', $dateApplicationNotify, $sms->sms_text);
            $approveSms1 = str_replace('/time/', $time, $approveSms);
            $approveSms2 = str_replace('/sp/', $sticker_category->price, $approveSms1);
            $approveSms3 = str_replace('/link/', $url_link, $approveSms2);
            $final_approveSms = str_replace('/reg/', $app->vehicleinfo->reg_number, $approveSms3);
            // $final_approveSms = str_replace('/reg/', $app->vehicleinfo->reg_number, $approveSms2);

            $follow_up = new FollowUp;
            $follow_up->application_id = $app->id;
            $follow_up->app_status = $app->app_status;
            $follow_up->status = "Application approved";
            $follow_up->created_date = Carbon::now();
            $follow_up->comment = $final_approveSms;
            $follow_up->updater_role = auth()->user()->role;
            $follow_up->updated_by = auth()->user()->name;
            $follow_up->save();
            $queue_status = "approve" . time();
            // $ApplicationNotify->applicant_phone;

            // Send SMS
            $follow_up = FollowUp::find($follow_up->id);
            $res = HomeController::callSmsApi($app->applicant->phone, $final_approveSms);

            $sms_sent = '';
            if ($res == 1) {
                /*$sms_applicant = new SmsApplicant;
                $sms_applicant->application_id = $follow_up->application_id;
                $sms_applicant->sms_id = $this->sms->id;
                $sms_applicant->sms_status = $this->sms->type;
                $sms_applicant->api_CamID = $res['CamID'];
                $sms_applicant->save();*/
                $sms_sent = 'success';
            } else {
                $sms_sent = 'fail';
            }

            $follow_up->sms_sent = $sms_sent;
            $follow_up->mail_sent = '';
            $follow_up->update();

            /*$job = (new SendSMSandMail($ApplicationNotify->applicant_phone,$final_approveSms,$app->applicant->email,$follow_up->id,$sms))
            ->onQueue($queue_status)->delay(Carbon::now()->addSeconds(0));
            dispatch($job); */

            $successOrFail = "success";
            $data = "Application approved successfully!!";
            $changleDate = date('d-m-Y', strtotime($request->sticker_delivery_date));
            return json_encode(array($data, $successOrFail, $app, $queue_status, $changleDate, $follow_up));
        } elseif ($app->app_status == "approved") {
            $successOrFail = "fail";
            $data = "This Application already approved";
            return json_encode(array($data, $successOrFail));
        } else {
            $data = "You can approve pending application only.Thank You.";
            $successOrFail = "not-now";
            return array($data, $successOrFail);
        }
    }


    public function issueSticker(Request $request){
        $final_issueSms="";
        $mail_status="";
        $app = Application::where('app_number',$request->app_number)->first();
        if($app->app_status == "approved" || $app->app_status == "PS approved"){
            if( $request->sticker_number!='' &&  $request->issue_type!='' && $request->sticker_exp_date!='' && $request->issue_sticker_date!='')
            {
                $sticker = new VehicleSticker;
                $sticker->application_id=$app->id;
                $sticker->sticker_value=$app->sticker_category;
                $sticker->reg_number=$app->vehicleinfo->reg_number;
                $sticker->issue_date=$request->issue_sticker_date;
                $sticker->exp_date=$request->sticker_exp_date;
                $sticker->sticker_number=$request->sticker_number;
                $sticker->applicant_id=$app->applicant->id;
                $sticker->save();
                $app= Application::findOrFail($app->id);
                if($app->app_status == "PS approved"){
                    $app->ps_approved = true;
                }
                $app->app_status ="issued";
                $app->save();
                $sms=Sms::where('type','=','issued')->first();
                $dummy_data = ["/reg/", "/issued-date/", "/expired-date/"];
                $real_data   = [$sticker->reg_number, $sticker->issue_date, $sticker->exp_date];
                $final_issueSms= str_replace($dummy_data, $real_data, $sms->sms_text);

                /*Mail::to($app->applicant->email)->send(new IssuedMail($final_issueSms));
                if (Mail::failures()){
                  $mail_status="fail";
                }else{
                  $mail_status="success";
                }*/
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->mail_sent=$mail_status;
                $follow_up->comment=$final_issueSms;
                $follow_up->status="Application Issued";
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                $invoice = new Invoice;
                $invoice->application_id=$app->id;
                $invoice->vehicle_sticker_id=$sticker->id;
                $invoice->number="StaHQD-".$app->app_number;
                $invoice->sticker_category_id=$app->stickerCategory->id;
                $invoice->vehicle_type_id=$app->vehicleinfo->vehicleType->id;
                $invoice->amount=$request->amount;
                $invoice->discount=$request->discount_amount;
                $invoice->net_amount=$request->total_amount;
                $invoice->case_type=$request->issue_type;
                $invoice->collector=auth()->user()->name;
                $invoice->invoice_date=Carbon::now();
                $invoice->comments=$request->comment;
                $invoice->save();
            }
            $data ="Sticker issued successfully!!";
            $flag=11;
            return array($flag,$data,$app->app_status,$invoice->id);
        }
        elseif($app->app_status == "issued"){
            $data ="This Application already issued";
            $flag=10;
            return array($flag,$data);
        }
        else {
            $flag=12;
            $data ="Not Approved application can not be Issued. Thank You.";
            return array($flag,$data);
        }
    }
    public function applicationForward(Request $request){
        $app = Application::where('app_number',$request->app_num)->first();
        if($app->app_status != "forwarded to PS" && $app->app_status == "pending"){

            $app->app_status = "forwarded to PS";
            $app->forwarded_date = Carbon::now();
            $app->save();
            $follow_up=new FollowUp;
            $follow_up->application_id=$app->id;
            $follow_up->updater_role=auth()->user()->role;
            $follow_up->app_status=$app->app_status;
            $follow_up->status="Application forwarded to PS";
            $follow_up->created_date=Carbon::now();
            $follow_up->updated_by=auth()->user()->name;
            $follow_up->save();
            $flag = 10;

            $data ="Application forwarded successfully!!";
            return array($flag,$data,$app->app_status);
        }
        elseif($app->app_status == "forwarded to PS"){
            $flag=11;
            $data ="This Application already forwarded.";
            return array($flag,$data);
        }else{
            $flag=12;
            $data ="You can forward only pending application.Thank You.";
            return array($flag,$data);
        }
    }

      //Start_New Modification
      public function replace_key($key)
      {
          $banglaKey = strtr($key, [1 => '১', 2 => '২', 3 => '৩', 4 => '৪', 5 => '৫', 6 => '৬', 7 => '৭', 8 => '৮', 9 => '৯', 0 => '০']);
          return $banglaKey;
      }
      //End_New Modification
    public function applicationReject(Request $request){

        $final_rejectSms="";
        $sms="";
        $queue_status                       = "";
        $successOrFail                      = "";
        $data                               = "";
        

        $app = Application::where('app_number',$request->app_num)->first();

        if($app->app_status == "pending" && ($request->missMatch!='' || $request->custom_sms_text!='' ||isset($request->other_sms)!='') ){


            $app->app_status = "updated";
            $app->rejected_date = Carbon::now();
            $app->retake = 1;
            $app->save();


            if($request->custom_sms_text!=''){

                $ApplicationNotify                      = new ApplicationNotify;
                $ApplicationNotify->application_id      = $app->id;
                $ApplicationNotify->applicant_phone     = $app->applicant->phone;
                $ApplicationNotify->app_status          = $app->app_status;

                $ApplicationNotify->custom_reject_sms   = $request->custom_sms_text;

                $final_rejectSms                        = $request->custom_sms_text;
                $sms                                    = Sms::findOrFail($request->sms_id);
                $ApplicationNotify->save();
                $follow_up=new FollowUp;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Application updated";
                $follow_up->created_date=Carbon::now();
                $follow_up->comment=$final_rejectSms;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->updated_by=auth()->user()->name;

                $follow_up->save();

                $queue_status                       = "updated".time();
                $successOrFail                      = "success";
                $data                               = "Application rejected successfully!!";

                $follow_up=FollowUp::find($follow_up->id);
                $custom_sms_res=HomeController::callSmsApi($ApplicationNotify->applicant_phone, $final_rejectSms);
                if ($custom_sms_res){
                    $sms_applicant = new SmsApplicant;
                    $sms_applicant->application_id = $follow_up->application_id;
                    $sms_applicant->sms_id = $sms->id;
                    $sms_applicant->sms_status = $sms->type;
                    $sms_applicant->api_CamID = '123';
                    $sms_applicant->save();
                    $sms_sent = 'success';
                }else{
                    $sms_sent = 'fail';
                }
                $follow_up->sms_sent=$sms_sent;
                $follow_up->update();



            }else{


                if($request->missMatch!=''){
                    $ApplicationNotify                      = new ApplicationNotify;
                    $ApplicationNotify->application_id      = $app->id;
                    $ApplicationNotify->applicant_phone     = $app->applicant->phone;
                    $ApplicationNotify->app_status          = $app->app_status;

                     //Start_New Modification

                    $missMatchArray = array();
                    foreach ($request->missMatch as $key => $value) {
                        $replace_key = $this->replace_key($key + 1);
                        $concat_massage = $replace_key .'.'. $value;
                        array_push($missMatchArray, $concat_massage);
                    }
                    //End_New Modification


                    $ApplicationNotify->mis_matched         = json_encode($missMatchArray);

                    $reject_sms_template                    = Sms::where('type','=','rejected')->first();

                    $missFile                               = json_decode($ApplicationNotify->mis_matched, true);
                    $allMissFile                            = implode( ", ", $missFile );
                    $rejectSms                              = str_replace('//', $allMissFile, $reject_sms_template->sms_text);
                    $final_rejectSms                        = str_replace('/reg/', $app->vehicleinfo->reg_number, $rejectSms);
                    $ApplicationNotify->save();

                    $follow_up                  = new FollowUp;
                    $follow_up->application_id  = $app->id;
                    $follow_up->app_status      = $app->app_status;
                    $follow_up->status          = "Application updated";
                    $follow_up->created_date    = Carbon::now();
                    $follow_up->comment         = $final_rejectSms;
                    $follow_up->updater_role    = auth()->user()->role;
                    $follow_up->updated_by      = auth()->user()->name;
                    $follow_up->save();


                    $follow_up                  = FollowUp::find($follow_up->id);
                    $reject_sms_response        = HomeController::callSmsApi($ApplicationNotify->applicant_phone, $final_rejectSms);

                    if ($reject_sms_response){
                        $sms_applicant                  = new SmsApplicant;
                        $sms_applicant->application_id  = $follow_up->application_id;
                        $sms_applicant->sms_id          = $reject_sms_template->id;
                        $sms_applicant->sms_status      = $reject_sms_template->type;
                        $sms_applicant->api_CamID       = '123';
                        $sms_applicant->save();

                        $sms_sent = 'success';
                    }else{
                        $sms_sent = 'fail';
                    }

                    $follow_up->sms_sent                = $sms_sent;
                    $follow_up->update();
                    $queue_status                       = "updated".time();
                    $successOrFail                      = "success";
                    $data                               = "Application rejected successfully!!";

                }
                if(isset($request->other_sms)!=''){

                    $ApplicationNotify                      = new ApplicationNotify;
                    $ApplicationNotify->application_id      = $app->id;
                    $ApplicationNotify->applicant_phone     = $app->applicant->phone;
                    $ApplicationNotify->app_status          = $app->app_status;


                    $ApplicationNotify->mis_matched         = json_encode($request->other_sms);

                    $reject_sms_template                    = Sms::where('type','=',$request->other_sms)->first();
                    $final_rejectSms                        = str_replace('/reg/', $app->vehicleinfo->reg_number, $reject_sms_template->sms_text);
                    $ApplicationNotify->save();

                    $follow_up                  = new FollowUp;
                    $follow_up->application_id  = $app->id;
                    $follow_up->app_status      = $app->app_status;
                    $follow_up->status          = "Application updated";
                    $follow_up->created_date    = Carbon::now();
                    $follow_up->comment         = $final_rejectSms;
                    $follow_up->updater_role    = auth()->user()->role;
                    $follow_up->updated_by      = auth()->user()->name;
                    $follow_up->save();


                    $follow_up                  = FollowUp::find($follow_up->id);
                    $reject_sms_response        = HomeController::callSmsApi($ApplicationNotify->applicant_phone, $final_rejectSms);


                    if ($reject_sms_response){
                        $sms_applicant                  = new SmsApplicant;
                        $sms_applicant->application_id  = $follow_up->application_id;
                        $sms_applicant->sms_id          = $reject_sms_template->id;
                        $sms_applicant->sms_status      = $reject_sms_template->type;
                        $sms_applicant->api_CamID       = '123';
                        $sms_applicant->save();

                        $sms_sent = 'success';
                    }else{
                        $sms_sent = 'fail';
                    }

                    $follow_up->sms_sent                = $sms_sent;
                    $follow_up->update();

                    $queue_status                       = "updated".time();
                    $successOrFail                      = "success";
                    $data                               = "Application rejected successfully!!";


                }


            }




            return array($data,$successOrFail,$app->app_status,$queue_status,$follow_up);

        }
        elseif($app->app_status == "updated"){

            $successOrFail      = "fail";
            $data               = "This Application already rejected";
            return array($data,$successOrFail);

        } else{
            $successOrFail      ="not-now";
            $data               ="You can reject only pending application.Thank You";

            return array($data,$successOrFail);
        }
    }


    public function applicationDelete(Request $request){
        $app = Application::where('app_number',$request->app_num)->first();
        if(auth()->user()->role =='super-admin'){
            if(!empty($app->driverinfo)){
                \File::delete('images/driver_nid/' . basename($app->driverinfo->nid_photo));
                \File::delete('images/driver_photo/' . basename($app->driverinfo->photo));
                \File::delete('images/driver_licence/' . basename($app->driverinfo->licence_photo));
                $app->driverinfo->delete();
            }
            if(!empty($app->vehicleowner)){
                \File::delete('images/vehicle_owner_nid/' . basename($app->vehicleowner->nid_photo));
                $app->vehicleowner->delete();
            }
            if(!empty($app->vehicleinfo)){
                \File::delete('images/vehicle_reg/' . basename($app->vehicleinfo->reg_cert_photo));
                \File::delete('images/vehicle_insurance/' . basename($app->vehicleinfo->insurance_cert_photo));
                \File::delete('images/vehicle_tax_token/' . basename($app->vehicleinfo->tax_token_photo));
                \File::delete('images/vehicle_fitness/' . basename($app->vehicleinfo->fitness_cert_photo));
                $app->vehicleinfo->delete();
            }
            if(!empty($app->vehicleSticker))
            {$app->vehicleSticker->delete();}
            if(count($app->followups)>0)
            {
                foreach ($app->followups as $key => $value){
                    $value->delete();
                }
            }
            if(!empty($app->applicationNotify)){
                $app->applicationNotify->delete();
            }
            \File::delete('images/application/' . basename($app->app_photo));
            $app->delete();

            $data ="Application deleted successfully!!";
            $flag='hard-deleted';
            return array($flag,$data);
        }
        if($app->app_status  == "pending"){
            $app->app_status = "deleted";
            $app->save();
            $data ="Application deleted temporarily. Only Super Admin can delete permanently.";
            $flag='soft-deleted';
            $follow_up=new FollowUp;
            $follow_up->application_id=$app->id;
            $follow_up->app_status=$app->app_status;
            $follow_up->status="Application deleted";
            $follow_up->created_date=Carbon::now();
            $follow_up->updater_role=auth()->user()->role;
            $follow_up->updated_by=auth()->user()->name;
            $follow_up->save();
            return array($flag,$data,$app->app_status);
        }
        elseif($app->app_status == "deleted"){
            $data ="Already deleted. Only Super Admin can delete permanently.";
            $flag='already-deleted';
            return array($flag,$data);
        }
        elseif($app->app_status != "deleted" || $app->app_status  != "pending"){
            $data ="You can delete pending application only.Thank You.";
            $flag='fail';
            return array($flag,$data);
        }
    }
    public function applicationEdit($appNumber){
        $vehicleTypes=VehicleType::orderBy('name','ASC')->get();
        $ranks=Rank::orderBy('name','ASC')->get();
        $units=SpouseParentsUnit::orderBy('name','ASC')->get();
        $app = Application::where('app_number', $appNumber)->first();
        return view('apps.edit',compact('app','vehicleTypes','ranks','units'));
    }
    public function notify(Request $request){
        $msg=$request->sms_text;
        $queue_status="mail".time();

        $follow_up=new FollowUp;
        $follow_up->updater_role=auth()->user()->role;
        $follow_up->application_id=$request->app_id;
        $follow_up->status="Notified applicant via mail";
        $follow_up->comment=$request->sms_text;
        $follow_up->created_date=Carbon::now();
        $follow_up->updated_by=auth()->user()->name;
        $follow_up->save();
        $job = (new SendMail($request->app_email,$msg,$follow_up->id))
            ->onQueue($queue_status)->delay(Carbon::now()->addSeconds(0));
        dispatch($job);
        $data="Mail has been sent Successfully!";
        $flag="success";
        return array($data,$flag, $queue_status,$follow_up);
    }
    public function bankDeposit(){
        $deposits= BankDeposit::all();
        return view('layouts.bank-deposit-form',compact('deposits'));
    }
    public function storeBankDeposit(Request $req){
        $new_bank_deposit = new BankDeposit;
        $new_bank_deposit->depositor_name = $req->depositor_name;
        $new_bank_deposit->bank_name = $req->bank_name;
        $new_bank_deposit->bank_acc_no = $req->bank_acc_no;
        $new_bank_deposit->amount = $req->amount;
        $new_bank_deposit->deposit_date = $req->deposit_date;
        $new_bank_deposit->created_by = auth()->user()->name;
        $new_bank_deposit->save();
        $data= 'Bank Deposit Added Successfully!';
        return array($data,$new_bank_deposit);
    }
    public function undoApplication(Request $request){
        $followups = FollowUp::where('application_id',$request->app_id)
            ->where('app_status','!=','warned')
            ->where('app_status','!=','expired')
            ->where('app_status','!=','')
            ->orderBy('created_at','desc')->get();
        $undostatus=array();
        $app=Application::findOrFail($request->app_id);



        foreach($followups as $key=>$follow_up){
            array_push($undostatus,$follow_up->app_status);
        }

//    echo '<pre>';
//
//    print_r($undostatus);
//    die('ff');

        foreach($undostatus as $k=>$undo ){
            if($undo=="issued"){
                if(!empty($app->vehicleSticker))
                {
                    $app->vehicleSticker->delete();
                }
                $app->app_status=$undostatus[$k+1];
                $app->save();
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Backed into".' '.$app->app_status;
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                break;
            }
            elseif($undo=="approved"){
                if(!empty($app->applicationNotify))
                {
                    $app->applicationNotify->delete();
                }
                $app->app_status="pending";
                $app->sticker_category="";
                $app->save();
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Backed into".' '.$app->app_status;
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                break;
            }
            elseif($undo=="PS approved"){
                if(!empty($app->applicationNotify)){
                    $app->applicationNotify->delete();
                }
                $app->app_status="forwarded to PS";
                $app->ps_approved=false;
                $app->sticker_category="";
                $app->save();
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Backed into".' '.$app->app_status;
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                break;
            }
            elseif($undo=="forwarded to PS"){
                $app->app_status="pending";
                $app->forwarded_date="";
                $app->save();
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Backed into".' '.$app->app_status;
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                break;
            }elseif($undo=="updated"){

                if(!empty($app->applicationNotify)){
                    $app->applicationNotify->delete();
                }
                $app->app_status="pending";
                $app->rejected_date="";
                $app->save();
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Backed into".' '.$app->app_status;
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                break;
            }elseif($undo=="hold"){

                if(!empty($app->applicationNotify)){
                    $app->applicationNotify->delete();
                }
                $app->app_status="pending";
                $app->rejected_date="";
                $app->save();
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Backed into".' '.$app->app_status;
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                break;
            }elseif($undo=="deleted"){
                $app->app_status="pending";
                $app->save();
                $follow_up=new FollowUp;
                $follow_up->updater_role=auth()->user()->role;
                $follow_up->application_id=$app->id;
                $follow_up->app_status=$app->app_status;
                $follow_up->status="Backed into".' '.$app->app_status;
                $follow_up->created_date=Carbon::now();
                $follow_up->updated_by=auth()->user()->name;
                $follow_up->save();
                break;
            }else{
                $res = 'No more undo at this time';
                $failOrSuccess="fail";
                return array($res,$failOrSuccess);
            }
        }
        $res='Undo done successfully';
        $failOrSuccess="success";
        return array($res,$failOrSuccess, $app->app_status);
    }
    public function HoldApplication(Request $request) {

        $followups = FollowUp::where('application_id',$request->app_id)
            ->where('app_status','!=','warned')
            ->where('app_status','!=','expired')
            ->where('app_status','!=','')
            ->orderBy('created_at','desc')->get();

        $app=Application::findOrFail($request->app_id);


        $app->app_status="hold";
        $app->save();
        $follow_up=new FollowUp;
        $follow_up->updater_role=auth()->user()->role;
        $follow_up->application_id=$app->id;
        $follow_up->app_status=$app->app_status;
        $follow_up->status="Moved into".' '.$app->app_status;
        $follow_up->comment=$request->holdingMessage;
        $follow_up->created_date=Carbon::now();
        $follow_up->updated_by=auth()->user()->name;
        $follow_up->save();


        return 'success';


    }
    public function deliveryReport(){
        $sticker_reports=VehicleSticker::groupBy('sticker_value')->get();
        return view('layouts.sticker-report',compact('sticker_reports'));
    }
    public function searchStickerReport(Request $request){
        if ($request->start_sticker_date != ''){
            $start = date('Y-m-d',strtotime($request->start_sticker_date));
        }
        if ($request->end_sticker_date !=''){
            $end = date('Y-m-d',strtotime($request->end_sticker_date));
        }


        if ($request->start_sticker_date != '' && $request->end_sticker_date !=''){
            $sticker_reports= VehicleSticker::whereBetween('issue_date', [$start, $end])->orderBy('created_at','desc')->groupBy('sticker_value')->get();
        }
        return view('layouts.sticker-report',compact('sticker_reports'))->with('date_from', $request->start_sticker_date)->with('date_to', $request->end_sticker_date);
    }

    public function allApproveApps(Request $request){
        $sticker_category = $request->sticker_category??"";
        $inspec_from_date = $request->inspec_from_date??"";
        $inspec_to_date = $request->inspec_to_date??"";

        // Search data
        $stickerTypes = StickerCategory::all();
        $applicant_name = $request->applicant_name ?? "";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $date = $request->date ?? "";
        $Vehicle_Type = $request->Vehicle_Type ?? "";
        $glass_type = $request->Vehicle_Type ?? "";
        $sticker_type = $request->sticker_type ?? "";
        $present_address = $request->present_address ?? "";

        $apps = Application::with('applicant', 'vehicleinfo', 'applicationNotify', 'applicant.applicantDetail', 'applicant.applicantDetail.rank')->where('app_status', 'approved')->groupBy('sticker_category')->get();
        return view('apps.inspection-list', compact('sticker_category', 'inspec_from_date', 'inspec_to_date','applicant_name', 'ba', 'rank', 'reg_no', 'phone', 'date', 'Vehicle_Type', 'glass_type', 'present_address','apps'));
    }

    public function approvedAppsDatatable(Request $request)
    {
        $query = Application::with(['applicant', 'vehicleinfo', 'applicationNotify', 'applicant.applicantDetail', 'vehicleinfo.vehicleType','applicant.applicantDetail.rank'])->whereIn('app_status', ['approved', 'PS approved']);
        $sticker_category = $request->sticker_category;
        $from_date = request('inspec_from_date')? date('Y-m-d', strtotime(request('inspec_from_date'))):'';
        $to_date = request('inspec_to_date')? date('Y-m-d', strtotime(request('inspec_to_date'))):'';

        if($sticker_category){
            $query->where('sticker_category', $sticker_category);
        }

        if($from_date && $to_date){
            //$applicaation_ids = ApplicationNotify::whereBetween('sticker_delivery_date', [$from_date, $to_date])->pluck('application_id');
            //$query->whereIn('id', $applicaation_ids);
            $query->whereRaw("id IN (SELECT application_id FROM application_notifies where sticker_delivery_date BETWEEN '$from_date' AND ' $to_date' )");
        }

        // Search Data 
        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->rank) {
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $applicaation_ids = ApplicationNotify::whereDate('sticker_delivery_date', date('Y-m-d', strtotime($request->date)))->pluck('application_id');
            $query->whereIn('id', $applicaation_ids);
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->applicant_BA_no : '';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->addColumn('sticker_delivery_date', function (Application $application) {
                if(!empty($application->applicationNotify->sticker_delivery_date)){
                    return date('d-m-Y', strtotime($application->applicationNotify->sticker_delivery_date ?? ''));
                }

            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {
                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
            })
            ->rawColumns(['applicant_name', 'BA_no', 'Rank_id', 'phone_number', 'phone_number', 'sticker_delivery_date', 'vehicleType', 'address'])
            ->toJson();
    }

    public function searchInspecList(Request $request){

        if ($request->inspec_from_date !='') {
            $from_date = date('Y-m-d', strtotime($request->inspec_from_date));
        }
        if ($request->inspec_to_date !='') {
            $to_date = date('Y-m-d', strtotime($request->inspec_to_date));
        }


        if($request->inspec_from_date!='' && $request->inspec_to_date=='' && $request->sticker_type==''){
            $apps= DB::table('application_notifies')
                ->whereDate('sticker_delivery_date',$from_date)
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->where(function ($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select(
                    'applications.sticker_category',
                    'vehicle_infos.reg_number',
                    'application_notifies.sticker_delivery_date',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'ranks.name as rankName',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            return view('apps.inspection-list',compact('apps'))->with('inspec_from_date',$request->inspec_from_date);
        }
        elseif($request->inspec_from_date=='' && $request->inspec_to_date!='' && $request->sticker_type==''){
            $apps= DB::table('application_notifies')
                ->whereDate('sticker_delivery_date',$to_date)
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->where(function($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select(
                    'applications.sticker_category',
                    'vehicle_infos.reg_number',
                    'application_notifies.sticker_delivery_date',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'ranks.name as rankName',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            return view('apps.inspection-list',compact('apps'))->with('inspec_to_date',$request->inspec_to_date);
        }
        elseif($request->inspec_from_date !='' && $request->inspec_to_date !='' && $request->sticker_type==''){
// dd("Working");
            $apps= DB::table('application_notifies')
                ->whereBetween('sticker_delivery_date',[$from_date,$to_date])
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->where(function ($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select(
                    'applications.sticker_category',
                    'vehicle_infos.reg_number',
                    'application_notifies.sticker_delivery_date',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'ranks.name as rankName',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();


            return view('apps.inspection-list',compact('apps'))->with('inspec_to_date',$request->inspec_to_date)->with('inspec_from_date',$request->inspec_from_date);
        }
        elseif($request->inspec_from_date=='' && $request->inspec_to_date=='' && $request->sticker_type!=''){
            $apps= DB::table('application_notifies')
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->where('applications.sticker_category','=', $request->sticker_type)
                ->where(function($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select(
                    'applications.sticker_category',
                    'vehicle_infos.reg_number',
                    'application_notifies.sticker_delivery_date',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'ranks.name as rankName',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();
            return view('apps.inspection-list',compact('apps','stickerType'));
        }
        elseif($request->inspec_from_date!='' && $request->inspec_to_date=='' && $request->sticker_type!=''){
            $apps= DB::table('application_notifies')
                ->whereDate('sticker_delivery_date', $from_date)
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->where('applications.sticker_category','=',$request->sticker_type)
                ->where(function($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select(
                    'applications.sticker_category',
                    'vehicle_infos.reg_number',
                    'application_notifies.sticker_delivery_date',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'ranks.name as rankName',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();
            return view('apps.inspection-list',compact('apps','stickerType'))->with('inspec_from_date',$request->inspec_from_date);
        }
        elseif($request->inspec_from_date=='' && $request->inspec_to_date!='' && $request->sticker_type!=''){
            $apps= DB::table('application_notifies')
                ->whereDate('sticker_delivery_date', $to_date)
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->where('applications.sticker_category','=', $request->sticker_type)

                ->where(function($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select(
                    'applications.sticker_category',
                    'vehicle_infos.reg_number',
                    'application_notifies.sticker_delivery_date',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'ranks.name as rankName',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();
            return view('apps.inspection-list',compact('apps','stickerType'))->with('inspec_to_date',$request->inspec_to_date);
        }
        elseif($request->inspec_from_date!='' && $request->inspec_to_date!='' && $request->sticker_type!=''){
            $apps= DB::table('application_notifies')
                ->whereBetween('sticker_delivery_date', [$from_date, $to_date])
                ->join('applications', 'applications.id', '=', 'application_notifies.application_id')
                ->where('applications.sticker_category','=', $request->sticker_type)
                ->where(function($query) {
                    $query->where('applications.app_status', 'approved')
                        ->orWhere('applications.app_status', 'PS approved');
                })
                ->join('vehicle_infos', 'vehicle_infos.application_id', '=', 'applications.id')
                ->join('applicants', 'applicants.id', '=', 'applications.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select(
                    'applications.sticker_category',
                    'vehicle_infos.reg_number',
                    'application_notifies.sticker_delivery_date',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'ranks.name as rankName',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();
            return view('apps.inspection-list',compact('apps','stickerType'))->with('inspec_to_date',$request->inspec_to_date)->with('inspec_from_date',$request->inspec_from_date);
        }else{
            return redirect('/all-approved/application');
        }
    }
    public function adminsList(){
        $admins = User::where('role','admin')->get();
        return view('layouts.admin-list',compact('admins'));
    }
    public function addAdmin(Request $req){
        $this->validate($req,[
            'name' => 'required|unique:users',
            'email' => 'required|min:4',
            'role' => 'required|min:4',
            'password' => 'required|confirmed|min:4'
        ]);
        $user = new User;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->role=$req->role;
        $user->password=bcrypt($req->password);
        $user->save();
        $data ="New Admin has been added successfully.";
        return array($data,$user);
    }

    public function updateAdmin(Request $req,$id){
        $user =USer::findOrFail($id);
        $user->name=$req->name;
        $user->email=$req->email;
        $user->role=$req->role;
        $user->update();
        $data ="Admin has been updated successfully.";
        return array($data,$user);
    }
    public function deleteAdmin(Request $req){
        $user =USer::findOrFail($req->id);
        $user->delete();
        $data ="Admin has been deleted successfully!";
        return array($data);
    }
    public function stickerTypes(){
        $stickers=StickerCategory::orderBy('name','asc')->get();
        return view('layouts.sticker-list',compact('stickers'));
    }
    public function addSticker(Request $req){
        $this->validate($req,[
            'name' => 'required|unique:sticker_categories',
            'value' => 'required|string|max:2|unique:sticker_categories',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
        ]);
        $sticker = new StickerCategory;
        $sticker->name=$req->name;
        $sticker->value=$req->value;
        $sticker->price=$req->price;
        $sticker->duration=$req->duration;
        $sticker->created_by=auth()->user()->name;
        $sticker->updated_by='';
        $sticker->save();
        $data ="New Sticker has been added successfully.";
        return array($data,$sticker,Carbon::parse($sticker->created_at)->toDayDateTimeString(),Carbon::parse($sticker->updated_at)->toDayDateTimeString());
    }

    public function updateSticker(Request $req,$id){
        $sticker =StickerCategory::findOrFail($id);
        $sticker->name=$req->name;
        $sticker->value=$req->value;
        $sticker->price=$req->price;
        $sticker->duration=$req->duration;
        $sticker->updated_by=auth()->user()->name;
        $sticker->update();
        $data ="Sticker has been updated successfully.";
        return array($data,$sticker,Carbon::parse($sticker->created_at)->toDayDateTimeString(),Carbon::parse($sticker->updated_at)->toDayDateTimeString());
    }
    public function deleteSticker(Request $req){
        $sticker =StickerCategory::findOrFail($req->id);
        $sticker->delete();
        $data ="Sticker has been deleted successfully!";
        return array($data);
    }
    public function searchForwardedList(Request $request){

        if($request->forwarded_from_date !=''){
            $from_date = date('Y-m-d', strtotime($request->forwarded_from_date));
        }
        if($request->forwarded_to_date !=''){
            $to_date = date('Y-m-d', strtotime($request->forwarded_to_date));
        }

        if($request->forwarded_from_date!='' && $request->forwarded_to_date==''){
            $apps = Application::where('app_status', 'forwarded to PS')->whereDate('forwarded_date', $from_date)
                ->orderBy('updated_at','desc')->get();
            return view('apps.forwarded',compact('apps'))->with('forwarded_from_date',$request->forwarded_from_date);

        }
        elseif($request->forwarded_from_date=='' && $request->forwarded_to_date!=''){
            $apps = Application::whereDate('forwarded_date', $to_date)->where('app_status','forwarded to PS')->orderBy('updated_at','desc')->get();
            return view('apps.forwarded',compact('apps'))->with('forwarded_to_date',$request->forwarded_to_date);
        }
        elseif($request->forwarded_from_date!='' && $request->forwarded_to_date!=''){
            $apps = Application::whereBetween('forwarded_date', [$from_date, $to_date])->where('app_status','forwarded to PS')->orderBy('updated_at','desc')->get();
            return view('apps.forwarded',compact('apps'))
                ->with('forwarded_to_date',$request->forwarded_to_date)
                ->with('forwarded_from_date',$request->forwarded_from_date);
        }else{
            $apps = Application::where('app_status','forwarded to PS')->orderBy('updated_at','desc')->get();
            return view('apps.forwarded',compact('apps'));
        }
    }
    public static function allIssuedApps(){
        DB::statement(DB::raw('set @rownum=0'));
        return $stickerApps= DB::table('vehicle_stickers')
            ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
            ->whereIn('app_status', ['issued', 'warning', 'expired'])
            ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
            ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
            ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
            ->leftJoin('ranks', 'ranks.id', '=', 'applicant_details.rank_id')
            ->select('vehicle_stickers.sticker_value',
                'vehicle_stickers.reg_number',
                'vehicle_stickers.exp_date',
                'vehicle_stickers.issue_date',
                'vehicle_stickers.sticker_number',
                'applications.glass_type',
                'applications.app_date',
                'applications.ps_approved',
                'applications.app_number',
                'applicants.phone',
                'applicants.role',
                'applicants.name as applicantName',
                'applicant_details.address',
                'applicant_details.nid_number',
                'applicant_details.applicant_BA_no',
                'ranks.name as rankName',
                'applicant_details.rank_id',
                'vehicle_types.name as vehicleTypeName',
                DB::raw('@rownum  := @rownum  + 1 AS rownum')
            )
            ->orderBy('vehicle_stickers.created_at', 'DESC')
            ->get();
    }
// public function allIssuedList(){
//   $stickerApps=$this->allIssuedApps();
//   return view('apps.issued-sticker-list',compact('stickerApps'));
// }

    public function allIssuedList(Request $request)
    {
        $sticker_category = $request->sticker_category ?? "";
        $inspec_from_date = $request->inspec_from_date ?? "";
        $inspec_to_date = $request->inspec_to_date ?? "";

        $stickerTypes = StickerCategory::all();
        $applicant_name = $request->applicant_name ?? "";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $date = $request->date ?? "";
        $Vehicle_Type = $request->Vehicle_Type ?? "";
        $glass_type = $request->Vehicle_Type ?? "";
        $sticker_type = $request->sticker_type ?? "";
        $present_address = $request->present_address ?? "";

        $apps = Application::with('applicant', 'vehicleinfo', 'applicationNotify')->where('app_status', 'issued')->orWhere('app_status', 'warning')->orWhere('app_status', 'expired')->count();
        // dd($apps);
        // $apps = Application::with('applicant', 'vehicleinfo', 'applicationNotify')->where('app_status', 'approved')->groupBy('sticker_category')->get();
        return view('apps.issued-sticker-list', compact('sticker_category', 'inspec_from_date', 'inspec_to_date', 'applicant_name', 'ba', 'rank', 'reg_no', 'phone', 'date', 'Vehicle_Type', 'glass_type', 'present_address','apps'));
    }

    public function issuedAppsDatatable(Request $request)
    {
        $query = Application::with(['applicant', 'vehicleinfo', 'applicationNotify', 'applicant.applicantDetail', 'vehicleinfo.vehicleType', 'applicant.applicantDetail.rank'])->whereIn('app_status', ['issued', 'warning', 'expired']);
        $sticker_category = $request->sticker_category;
        $from_date = request('inspec_from_date') ? date('Y-m-d', strtotime(request('inspec_from_date'))) : '';
        $to_date = request('inspec_to_date') ? date('Y-m-d', strtotime(request('inspec_to_date'))) : '';

// return "F:".$from_date.'T:'.$to_date;
   
        if ($from_date && $to_date) {
           // $applicaation_ids = VehicleSticker::whereBetween('issue_date', [$from_date, $to_date])->pluck('application_id');
            $query->whereRaw("id IN (SELECT application_id FROM vehicle_stickers where issue_date BETWEEN '$from_date' AND '$to_date' )");
        }
   



  if ($sticker_category) {
            $query->where('sticker_category', $sticker_category);
        }


        // Search Data 
        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
                        
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->rank) {
            $rank_ids = Rank::where('name', 'like',  '%' . $request->rank . '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_ids)->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $query->whereIn('applicant_id', $applicant_ids);
        }

        if ($request->reg_no) {
            $application_ids = vehicleinfo::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query->whereIn('id', $application_ids);
        }

        if ($request->date) {
            $query->where('app_date', date('Y-m-d', strtotime($request->date)));
        }

        if ($request->Vehicle_Type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->Vehicle_Type . '%')->pluck('id');
            $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }



        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('applicant_name', function (Application $application) {
                $nid = ($application->applicant->applicantDetail) ? $application->applicant->applicantDetail->nid_number : '';
                return '<a href="' . route('application.review', ['app_number' => $application->app_number]) . '" target="_blank">' . $application->applicant->name . '</a><br>' . $nid;
            })
            ->addColumn('BA_no', function (Application $application) {
                $ba_no = $application->applicant->applicantDetail->applicant_BA_no??'';

                return $ba_no;
            })
            ->addColumn('Rank_id', function (Application $application) {
                $rank_id =  $application->applicant->applicantDetail->rank->name??'';
                return $rank_id;
            })
            ->addColumn('Reg_number', function (Application $application) {
                $reg_number = $application->vehicleinfo->reg_number??'';
                return $reg_number;
            })
            ->addColumn('phone_number', function (Application $application) {
                return $application->applicant->phone;
            })
            ->editColumn('app_date', function (Application $application) {
                return date('d-m-Y', strtotime($application->app_date));
            })
            ->addColumn('sticker_delivery_date', function (Application $application) {
                if(!empty($application->applicationNotify)){
                    return date('d-m-Y', strtotime($application->applicationNotify->sticker_delivery_date??''));
                }

            })
            ->addColumn('vehicleType', function (Application $application) {
                $vehicle_type = $application->vehicleinfo->vehicleType->name??'';
                return $vehicle_type;
            })
            ->addColumn('address', function (Application $application) {
                $app_address = ($application->applicant->applicantDetail) ? json_decode($application->applicant->applicantDetail->address, true) : '';
                return $app_address['present']['flat'] . ', ' . $app_address['present']['house'] . ', ' . $app_address['present']['road'] . ', ' . $app_address['present']['block'] . ', ' . $app_address['present']['area'] . '.';
            })
            ->rawColumns(['applicant_name', 'BA_no', 'Rank_id', 'phone_number', 'phone_number', 'sticker_delivery_date', 'vehicleType', 'address'])
            ->toJson();
    }

    public function DataTableIssuedAppsFetch(Request $request){
        $stickerApps=$this->allIssuedApps();
        return Datatables::of($stickerApps)
            ->addColumn('name_nid', '<a href="/application-review/{{$app_number}}" target="_blank">{{$applicantName}}</a> <br> {{$nid_number}}')
            ->editColumn('address', 'datatables.address')
            ->rawColumns(['name_nid','address'])
            ->toJson();
    }

    public function searchIssuedList(Request $request){

        if ($request->issued_from_date !='') {
            $from_date = date('Y-m-d',strtotime($request->issued_from_date));

        }
        if ($request->issued_to_date !='') {
            $to_date= date('Y-m-d',strtotime($request->issued_to_date));
        }

        if($request->issued_from_date!='' && $request->issued_to_date=='' && $request->sticker_type==''){
            $stickerApps= DB::table('vehicle_stickers')
                ->whereDate('issue_date', $from_date)
                ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
                ->whereIn('app_status', ['issued', 'warning', 'expired'])
                ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select('vehicle_stickers.sticker_value',
                    'vehicle_stickers.reg_number',
                    'vehicle_stickers.exp_date',
                    'vehicle_stickers.issue_date',
                    'vehicle_stickers.sticker_number',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'applicant_details.rank_id',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            return view('apps.issued-sticker-list',compact('stickerApps'))->with('issued_from_date',$request->issued_from_date);
        }
        elseif($request->issued_from_date=='' && $request->issued_to_date!='' && $request->sticker_type==''){
            $stickerApps= DB::table('vehicle_stickers')
                ->whereDate('issue_date',$to_date)
                ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
                ->whereIn('app_status', ['issued', 'warning', 'expired'])
                ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select('vehicle_stickers.sticker_value',
                    'vehicle_stickers.reg_number',
                    'vehicle_stickers.exp_date',
                    'vehicle_stickers.issue_date',
                    'vehicle_stickers.sticker_number',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'applicant_details.rank_id',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            return view('apps.issued-sticker-list',compact('stickerApps'))->with('issued_to_date',$request->issued_to_date);
        }
        elseif($request->issued_from_date=='' && $request->issued_to_date!='' && $request->sticker_type!=''){
            $stickerApps= DB::table('vehicle_stickers')
                ->whereDate('issue_date', $to_date)
                ->where('sticker_value', $request->sticker_type)
                ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
                ->whereIn('app_status', ['issued', 'warning', 'expired'])
                ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select('vehicle_stickers.sticker_value',
                    'vehicle_stickers.reg_number',
                    'vehicle_stickers.exp_date',
                    'vehicle_stickers.issue_date',
                    'vehicle_stickers.sticker_number',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'applicant_details.rank_id',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();

            return view('apps.issued-sticker-list',compact('stickerApps','stickerType'))->with('issued_to_date',$request->issued_to_date);
        }
        elseif($request->issued_from_date!='' && $request->issued_to_date=='' && $request->sticker_type!=''){
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();

            $stickerApps= DB::table('vehicle_stickers')
                ->whereDate('vehicle_stickers.issue_date', $from_date)
                ->where('vehicle_stickers.sticker_value', $request->sticker_type)
                ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
                ->whereIn('app_status', ['issued', 'warning', 'expired'])
                ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select('vehicle_stickers.sticker_value',
                    'vehicle_stickers.reg_number',
                    'vehicle_stickers.exp_date',
                    'vehicle_stickers.issue_date',
                    'vehicle_stickers.sticker_number',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'applicant_details.rank_id',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            return view('apps.issued-sticker-list',compact('stickerApps','stickerType'))->with('issued_from_date',$request->issued_from_date);
        }
        elseif($request->issued_from_date!='' && $request->issued_to_date!='' && $request->sticker_type==''){
            $stickerApps= DB::table('vehicle_stickers')
                ->whereBetween('issue_date', [$from_date, $to_date])
                ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
                ->whereIn('app_status', ['issued', 'warning', 'expired'])
                ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select('vehicle_stickers.sticker_value',
                    'vehicle_stickers.reg_number',
                    'vehicle_stickers.exp_date',
                    'vehicle_stickers.issue_date',
                    'vehicle_stickers.sticker_number',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'applicant_details.rank_id',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            return view('apps.issued-sticker-list',compact('stickerApps'))->with('issued_to_date',$request->issued_to_date)->with('issued_from_date',$request->issued_from_date);
        }
        elseif($request->issued_from_date=='' && $request->issued_to_date=='' && $request->sticker_type!=''){
            $stickerApps= DB::table('vehicle_stickers')
                ->where('sticker_value', $request->sticker_type)
                ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
                ->whereIn('app_status', ['issued', 'warning', 'expired'])
                ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select('vehicle_stickers.sticker_value',
                    'vehicle_stickers.reg_number',
                    'vehicle_stickers.exp_date',
                    'vehicle_stickers.issue_date',
                    'vehicle_stickers.sticker_number',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'applicant_details.rank_id',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();
            return view('apps.issued-sticker-list',compact('stickerApps','stickerType'));
        }
        elseif($request->issued_from_date!='' && $request->issued_to_date!='' && $request->sticker_type!=''){
            $stickerType =StickerCategory::where('value',$request->sticker_type)->first();
            $stickerApps= DB::table('vehicle_stickers')
                ->whereBetween('issue_date', [$from_date, $to_date])
                ->where('sticker_value', $request->sticker_type)
                ->join('applications', 'applications.id', '=', 'vehicle_stickers.application_id')
                ->whereIn('app_status', ['issued', 'warning', 'expired'])
                ->join('applicants', 'applicants.id', '=', 'vehicle_stickers.applicant_id')
                ->join('applicant_details', 'applicant_details.applicant_id', '=', 'applicants.id')
                ->join('vehicle_types', 'vehicle_types.id', '=', 'applications.vehicle_type_id')
                ->select('vehicle_stickers.sticker_value',
                    'vehicle_stickers.reg_number',
                    'vehicle_stickers.exp_date',
                    'vehicle_stickers.issue_date',
                    'vehicle_stickers.sticker_number',
                    'applications.glass_type',
                    'applications.app_date',
                    'applications.ps_approved',
                    'applications.app_number',
                    'applicants.phone',
                    'applicants.role',
                    'applicants.name as applicantName',
                    'applicant_details.address',
                    'applicant_details.nid_number',
                    'applicant_details.applicant_BA_no',
                    'applicant_details.rank_id',
                    'vehicle_types.name as vehicleTypeName'
                )
                ->get();
            return view('apps.issued-sticker-list',compact('stickerApps','stickerType'))->with('issued_to_date',$request->issued_to_date)->with('issued_from_date',$request->issued_from_date);
        }else{
            return redirect('/all-issued/application');
        }
    }


    public function allStickerApplications(Request $request)
    {
        $apps=$this->allData();
        $columns = array(
            0 =>'id',
            1 =>'title',
            2=> 'body',
            3=> 'created_at',
            4=> 'id',
        );

        $totalData = Post::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = Post::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  Post::where('id','LIKE',"%{$search}%")
                ->orWhere('title', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Post::where('id','LIKE',"%{$search}%")
                ->orWhere('title', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('posts.show',$post->id);
                $edit =  route('posts.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['title'] = $post->title;
                $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
      &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);

    }
//    public static function callSmsApi($applicant_phone,$sms)
//    {
//
//        if (strlen($applicant_phone) == 11) {
//            $applicant_phone = '88' . $applicant_phone;
//        }
//        $applicant_phone = str_replace('+', '', $applicant_phone);
//
//
//        $link = DB::table('sms_api')->where('status',1)->first();
//
//        if($link){
//
//            $from = $link->masking_name;
//            $username = $link->username;
//            $password = $link->password;
//
//            $url = $link->url.'Username='.$username.'&Password='.$password.'&From='.urlencode($from).'&To='.$applicant_phone.'&Message='.urlencode($sms);
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_FAILONERROR, true);
//
//            $content  = curl_exec($ch);
//
//            $xml = simplexml_load_string($content);
//
//            if (isset($xml->ServiceClass)) {
//                if ($xml->ServiceClass->Status == 0) {
//
//                    $redirectLink = DB::table('sms_redirect_2ait')->where('status',1)->first();
//
//
//                    if($redirectLink){
//
//                        $msgfinal = urlencode($sms);
//                        $url = $redirectLink->url_name;
//                        $data = "user=$redirectLink->user&pass=$redirectLink->pass&text=$msgfinal&mobile=$applicant_phone";
//                        $all = $url . '?' . $data;
//                       $reply = file_get_contents($all);
//                    }else{
//                        return '2A IT redirecting link problem';
//                    }
//
//
//
//
//                }
//            }
//
//            if (isset($xml->ServiceClass) && $xml->ServiceClass->Status == 0)
//                return 1;
//            else
//                return 0;
//
//        }else{
//            return 'null data';
//        }





        /*$mno = array();
        $mno[] = $applicant_phone;
        $message = $sms;
        $url = 'http://panel.aamarsms.com/api/sendsms';
        $ch = curl_init($url);
        $jsonData = array(

            'UserName' => 'stahqdhk',
            'Password' => '@dmin210',
            'MSISDN' => $mno,
            'Message' => $message,
            'Mask' => 'STA HQ DHK'
        );
        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        echo $result = curl_exec($ch);
        curl_close($ch);*/
   // }

    public static function callSmsApi($applicant_phone,$sms,$isBulk=0)
    {

        if (strlen($applicant_phone) == 11) {
            $applicant_phone = '88' . $applicant_phone;
        }


        $api_key = "EIYTeICDZwdCRWSmGmq7";
        $senderid = "STA HQ DHK";
        $number = $applicant_phone;


        $data=null;
        if(!$isBulk){
            $url = "https://bulksmsbd.net/api/smsapi";
            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "number" => $number,
                "message" => $sms
            ];


        }else{
            $url = "https://bulksmsbd.net/api/smsapimany";
            $messages = json_encode($sms);
            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "messages" => $messages
            ];
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);


// return 1;

       if(json_decode($response)->response_code==202){
           return 1;
       }else{
           return 0;
       }
        return json_decode($response)->response_code;

    }
    
    public function rhythm(){
        // $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->addMonth(3);

        // HomeController::callSmsApi('01761955765', 'SMS is Working');
    }
}
