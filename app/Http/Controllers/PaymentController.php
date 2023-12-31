<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\ApplicantDetail;
use App\Application;
use App\ApplicationNotify;
use App\Payment;
use App\Rank;
use App\StickerCategory;
use App\VehicleInfo;
use App\VehicleSticker;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function paymentView($id)
    {

                $mapping_id_special=[
                    'Ya'=>0,
                    'Is'=>1,
                    'Pa'=>2,
                    'Nq'=>3,
                    'MV'=>4,
                    'rD'=>5,
                    'QH'=>6,
                    'Lm'=>7,
                    'Nb'=>8,
                    'Ei'=>9
        ];
        $splited=str_split($id,2);
        //dd($id);
        $decryptedId='';
        foreach($splited as $key=>$value)
        {
            $decryptedId =$decryptedId.$mapping_id_special[$value];
        }
        $application = Application::find($decryptedId);

        return view('payment_gateway.payment_view', compact('application'));
    }

    public function payment_success($id)
    {
        $application = Application::find($id);

        return view('payment_gateway.payment_success', compact('application'));
    }

    public function paymentReportData(Request $request)
    {
        $sticker_categories = StickerCategory::all();
        $applicant_name = $request->applicant_name ?? "";
        $applicant_type = $request->applicant_type ?? "";
        $sticker_type = $request->sticker_category ?? "";     
        $inspec_from_date = $request->inspec_from_date??"";
        $inspec_to_date = $request->inspec_to_date??"";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $vehicle_type = $request->vehicle_type ?? "";
        $present_address = $request->present_address ?? "";
        $approval_count = $request->approval_count ?? "";
        
      return view('payment_gateway.payment-report-list', compact('sticker_categories','applicant_name','applicant_type','sticker_type','inspec_from_date','inspec_to_date','ba','rank','reg_no','phone','vehicle_type','present_address','approval_count'));
        
    }
    public function paymentReportDatatable(Request $request)
    {
        $query = Payment::join('applications', 'applications.id', 'payments.application_id')
            ->leftJoin('applicants', 'applicants.id', 'applications.applicant_id') 
            ->leftJoin('vehicle_types', 'vehicle_types.id', 'applications.vehicle_type_id')
            ->leftJoin('applicant_details', 'applicants.id', 'applicant_details.applicant_id')
            ->leftJoin('ranks', 'ranks.id', 'applicant_details.rank_id')
            ->leftJoin('vehicle_stickers', 'applications.id', 'vehicle_stickers.application_id');
            
        $from_date = request('inspec_from_date') ? date('Y-m-d', strtotime(request('inspec_from_date'))) : '';
        $to_date = request('inspec_to_date') ? date('Y-m-d', strtotime(request('inspec_to_date'))) : '';

        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->applicant_type) {
            $applicant_ids = Applicant::where('role', 'like', '%' . $request->applicant_type. '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->sticker_type) {
            $application_ids = Application::where('sticker_category', 'like', '%' . $request->sticker_type. '%')->pluck('id');
            $query = $query->whereIn('payments.application_id', $application_ids);
        }   
        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba. '%')->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id); 
        }
        if ($request->rank) {
            $rank_id=Rank::where('name', 'like', '%' . $request->rank. '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_id)->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id); 
        }
        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->vehicle_type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->vehicle_type . '%')->pluck('id');
           $query= $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }
        if ($request->reg_no) {
            $application_ids = VehicleSticker::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query=$query->whereIn('payments.application_id', $application_ids);
        }
        if ($from_date && $to_date) {
            $payment_ids = Payment::whereBetween('created_at', [$from_date, $to_date])->pluck('id');
            $query->whereIn('payments.id', $payment_ids);   
        }
        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id);
        }
        if ($request->approval_count) {
            if ($request->approval_count == '1st') {
                $application_ids = Application::where('approval_count', '=', 1)->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            } elseif ($request->approval_count == '2nd') {
                $application_ids = Application::where('approval_count', '>', 1)->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            } else {
                $application_ids = Application::where('approval_count', 'like', '%' . $request->approval_count. '%')->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            }
        }
        
        $query = $query->select('applicants.name as applicant_name','applications.app_number','applicants.phone', 'applicants.role as applicant_role'
        ,'applications.sticker_category','applications.glass_type', 'vehicle_types.name as vehicle_name','applicant_details.applicant_BA_no','applicant_details.address','ranks.name as rank_name','vehicle_stickers.reg_number as sticker_reg_number','payments.*', 'applications.approval_count')
        ->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($query) {
                $name = ($query->applicant_name) ? $query->applicant_name : '';
                return '<a href="' . route('application.review', ['app_number' => $query->app_number]) . '" target="_blank">' . $name. '</a>';               
            })
            ->addColumn('type', function ($query) {
                $type = ($query->applicant_role) ? $query->applicant_role : '';
                return $type;
            })
            ->addColumn('sticker_category', function ($query) {
                $sticker_category = ($query->sticker_category) ? $query->sticker_category : '';
                return $sticker_category;
            })
            ->addColumn('glass_type', function ($query) {
                $glass_type = ($query->glass_type) ? $query->glass_type : '';
                return $glass_type;
            })
            ->addColumn('vehicle_name', function ($query) {
                $vehicle_name = ($query->vehicle_name) ? $query->vehicle_name : '';
                return $vehicle_name;
            })
            ->addColumn('phone', function ($query) {
                $phone = ($query->phone) ? $query->phone : '';
                return $phone;
            })
            ->addColumn('rank_name', function ($query) {
                $rank_name = ($query->rank_name) ? $query->rank_name : '';
                return $rank_name;
            })
            ->addColumn('applicant_BA_no', function ($query) {
                $applicant_BA_no = ($query->applicant_BA_no) ? $query->applicant_BA_no : '';
                return $applicant_BA_no;
            })
            ->addColumn('sticker_reg_number', function ($query) {
                $sticker_reg_number = ($query->sticker_reg_number) ? $query->sticker_reg_number : '';
                return $sticker_reg_number;
            })
            ->addColumn('address', function ($query) {
                $address = ($query->address) ? json_decode($query->address, true) : '';
                return $address['present']['flat'] . ', ' . $address['present']['house'] . ', ' . $address['present']['road'] . ', ' . $address['present']['block'] . ', ' . $address['present']['area'] . '.';
                
            })
            ->addColumn('approval_count', function ($query) {
                $approval_count = ($query->approval_count) ? $query->approval_count : '';
                if($approval_count==1){
                    return '1st time';
                }elseif($approval_count>=2){
                    return '2nd time';
                }else{
                    return "None"; 
                }   
            })
            ->with('sum_balance', $query->sum('credit'))     
            ->rawColumns(['name', 'type', 'sticker_category', 'create_at', 'created_by', 'credit','vehicle_name','glass_type','phone','rank_name','applicant_BA_no','sticker_reg_number','address','approval_count'])
            ->toJson();
    }

    public function allPaidRecollect()
    {
        return view('payment_gateway.payment_paid_recollect');
    }
    public function defpaymentReportData(Request $request)
    {
        $sticker_categories = StickerCategory::all();
        $applicant_name = $request->applicant_name ?? "";
        $applicant_type = $request->applicant_type ?? "";
        $sticker_type = $request->sticker_category ?? "";     
        $inspec_from_date = $request->inspec_from_date??"";
        $inspec_to_date = $request->inspec_to_date??"";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $vehicle_type = $request->vehicle_type ?? "";
        $present_address = $request->present_address ?? "";
        $approval_count = $request->approval_count ?? "";
 
      return view('payment_gateway.def-payment-report-list', compact('sticker_categories','applicant_name','applicant_type','sticker_type','inspec_from_date','inspec_to_date','ba','rank','reg_no','phone','vehicle_type','present_address','approval_count'));   
    }
    public function defpaymentReportDatatable(Request $request)
    {
        $query = Payment::join('applications', 'applications.id', 'payments.application_id')
            ->leftJoin('applicants', 'applicants.id', 'applications.applicant_id') 
            ->leftJoin('vehicle_types', 'vehicle_types.id', 'applications.vehicle_type_id')
            ->leftJoin('applicant_details', 'applicants.id', 'applicant_details.applicant_id')
            ->leftJoin('ranks', 'ranks.id', 'applicant_details.rank_id')
            ->leftJoin('vehicle_stickers', 'applications.id', 'vehicle_stickers.application_id');
            
        $from_date = request('inspec_from_date') ? date('Y-m-d', strtotime(request('inspec_from_date'))) : '';
        $to_date = request('inspec_to_date') ? date('Y-m-d', strtotime(request('inspec_to_date'))) : '';

        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->applicant_type) {
            $applicant_ids = Applicant::where('role', 'like', '%' . $request->applicant_type. '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->sticker_type) {
            $application_ids = Application::where('sticker_category', 'like', '%' . $request->sticker_type. '%')->pluck('id');
            $query = $query->whereIn('payments.application_id', $application_ids);
        }
        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba. '%')->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id); 
        }
        if ($request->rank) {
            $rank_id=Rank::where('name', 'like', '%' . $request->rank. '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_id)->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id); 
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->vehicle_type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->vehicle_type . '%')->pluck('id');
           $query= $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }
        if ($request->reg_no) {
            $application_ids = VehicleSticker::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query=$query->whereIn('payments.application_id', $application_ids);
        }

        if ($from_date && $to_date) {
            $payment_ids = Payment::whereBetween('created_at', [$from_date, $to_date])->pluck('id');
            $query->whereIn('payments.id', $payment_ids);   
        }
        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id); 
        }
        if ($request->approval_count) {
            if ($request->approval_count == '1st') {
                $application_ids = Application::where('approval_count', '=', 1)->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            } elseif ($request->approval_count == '2nd') {
                $application_ids = Application::where('approval_count', '>', 1)->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            } else {
                $application_ids = Application::where('approval_count', 'like', '%' . $request->approval_count. '%')->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            }
        }

        $query = $query->select('applicants.name as applicant_name','applications.app_number','applicants.phone', 'applicants.role as applicant_role'
        , 'applications.sticker_category','applications.glass_type', 'vehicle_types.name as vehicle_name','applicant_details.applicant_BA_no','applicant_details.address','ranks.name as rank_name','vehicle_stickers.reg_number as sticker_reg_number','payments.*', 'applications.approval_count') 
        ->where('applicants.role', 'def')
        ->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($query) {
                $name = ($query->applicant_name) ? $query->applicant_name : '';
                return '<a href="' . route('application.review', ['app_number' => $query->app_number]) . '" target="_blank">' . $name. '</a>';
            })
            ->addColumn('type', function ($query) {
                $type = ($query->applicant_role) ? $query->applicant_role : '';
                return $type;
            })
            ->addColumn('sticker_category', function ($query) {
                $sticker_category = ($query->sticker_category) ? $query->sticker_category : '';
                return $sticker_category;
            })
            ->addColumn('glass_type', function ($query) {
                $glass_type = ($query->glass_type) ? $query->glass_type : '';
                return $glass_type;
            })
            ->addColumn('vehicle_name', function ($query) {
                $vehicle_name = ($query->vehicle_name) ? $query->vehicle_name : '';
                return $vehicle_name;
            })
            ->addColumn('phone', function ($query) {
                $phone = ($query->phone) ? $query->phone : '';
                return $phone;
            })
            ->addColumn('rank_name', function ($query) {
                $rank_name = ($query->rank_name) ? $query->rank_name : '';
                return $rank_name;
            })
            ->addColumn('applicant_BA_no', function ($query) {
                $applicant_BA_no = ($query->applicant_BA_no) ? $query->applicant_BA_no : '';
                return $applicant_BA_no;
            })
            ->addColumn('sticker_reg_number', function ($query) {
                $sticker_reg_number = ($query->sticker_reg_number) ? $query->sticker_reg_number : '';
                return $sticker_reg_number;
            })
            ->addColumn('address', function ($query) {
                $address = ($query->address) ? json_decode($query->address, true) : '';
                return $address['present']['flat'] . ', ' . $address['present']['house'] . ', ' . $address['present']['road'] . ', ' . $address['present']['block'] . ', ' . $address['present']['area'] . '.';  
            })
            ->addColumn('approval_count', function ($query) {
                $approval_count = ($query->approval_count) ? $query->approval_count : '';
                if($approval_count==1){
                    return '1st time';
                }elseif($approval_count>=2){
                    return '2nd time';
                }else{
                    return "None"; 
                } 
            })
            ->with('sum_balance', $query->sum('credit'))
            ->rawColumns(['name', 'type', 'sticker_category', 'create_at', 'created_by', 'credit','vehicle_name','glass_type','phone','rank_name','applicant_BA_no','sticker_reg_number','address','approval_count'])
            ->toJson();
    }
    public function NondefPaymentReportData(Request $request)
    {
        $sticker_categories = StickerCategory::all();
        $applicant_name = $request->applicant_name ?? "";
        $applicant_type = $request->applicant_type ?? "";
        $sticker_type = $request->sticker_category ?? "";     
        $inspec_from_date = $request->inspec_from_date??"";
        $inspec_to_date = $request->inspec_to_date??"";
        $ba = $request->ba ?? "";
        $rank = $request->rank ?? "";
        $reg_no = $request->reg_no ?? "";
        $phone = $request->phone ?? "";
        $vehicle_type = $request->vehicle_type ?? "";
        $present_address = $request->present_address ?? "";
        $approval_count = $request->approval_count ?? "";
 
      return view('payment_gateway.nondef-payment-report-list', compact('sticker_categories','applicant_name','applicant_type','sticker_type','inspec_from_date','inspec_to_date','ba','rank','reg_no','phone','vehicle_type','present_address','approval_count'));
        
    }
    public function NondefPaymentReportDatatable(Request $request)
    {
        $query = Payment::join('applications', 'applications.id', 'payments.application_id')
            ->leftJoin('applicants', 'applicants.id', 'applications.applicant_id') 
            ->leftJoin('vehicle_types', 'vehicle_types.id', 'applications.vehicle_type_id')
            ->leftJoin('applicant_details', 'applicants.id', 'applicant_details.applicant_id')
            ->leftJoin('ranks', 'ranks.id', 'applicant_details.rank_id')
            ->leftJoin('vehicle_stickers', 'applications.id', 'vehicle_stickers.application_id');
            
        $from_date = request('inspec_from_date') ? date('Y-m-d', strtotime(request('inspec_from_date'))) : '';
        $to_date = request('inspec_to_date') ? date('Y-m-d', strtotime(request('inspec_to_date'))) : '';

        if ($request->applicant_name) {
            $applicant_ids = Applicant::where('name', 'like', '%' . $request->applicant_name . '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->applicant_type) {
            $applicant_ids = Applicant::where('role', 'like', '%' . $request->applicant_type. '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->sticker_type) {
            $application_ids = Application::where('sticker_category', 'like', '%' . $request->sticker_type. '%')->pluck('id');
            $query = $query->whereIn('payments.application_id', $application_ids);
        }
        if ($request->ba) {
            $applicant_ids = ApplicantDetail::where('applicant_BA_no', 'like', '%' . $request->ba. '%')->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id); 
        }
        if ($request->rank) {
            $rank_id=Rank::where('name', 'like', '%' . $request->rank. '%')->pluck('id');
            $applicant_ids = ApplicantDetail::whereIn('rank_id', $rank_id)->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id); 
        }

        if ($request->phone) {
            $applicant_ids = Applicant::where('phone', 'like', '%' . $request->phone . '%')->pluck('id');
            $query = $query->whereIn('applications.applicant_id', $applicant_ids);
        }
        if ($request->vehicle_type) {
            $vehicle_type_ids = VehicleType::where('name', 'like', '%' . $request->vehicle_type . '%')->pluck('id');
           $query= $query->whereIn('vehicle_type_id', $vehicle_type_ids);
        }
        if ($request->reg_no) {
            $application_ids = VehicleSticker::where('reg_number', 'like', '%' . $request->reg_no . '%')->pluck('application_id');
            $query=$query->whereIn('payments.application_id', $application_ids);
        }

        if ($from_date && $to_date) {
            $payment_ids = Payment::whereBetween('created_at', [$from_date, $to_date])->pluck('id');
            $query->whereIn('payments.id', $payment_ids);   
        }
        if ($request->present_address) {
            $applicant_ids = ApplicantDetail::where('address', 'like', '%' . $request->present_address . '%')->pluck('applicant_id');
            $application_id=Application::whereIn('applicant_id', $applicant_ids)->pluck('id');
            $query=$query->whereIn('payments.application_id', $application_id);
        }
        if ($request->approval_count) {
            if ($request->approval_count == '1st') {
                $application_ids = Application::where('approval_count', '=', 1)->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            } elseif ($request->approval_count == '2nd') {
                $application_ids = Application::where('approval_count', '>', 1)->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            } else {
                $application_ids = Application::where('approval_count', 'like', '%' . $request->approval_count. '%')->pluck('id');
                $query = $query->whereIn('applications.id', $application_ids);
            }
        }

        $query = $query->select('applicants.name as applicant_name','applications.app_number','applicants.phone', 'applicants.role as applicant_role'
        , 'applications.sticker_category','applications.glass_type', 'vehicle_types.name as vehicle_name','applicant_details.applicant_BA_no','applicant_details.address','ranks.name as rank_name','vehicle_stickers.reg_number as sticker_reg_number','payments.*','applications.approval_count')
        ->where('applicants.role', 'non-def')
        ->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', function ($query) {
                $name = ($query->applicant_name) ? $query->applicant_name : '';
                return '<a href="' . route('application.review', ['app_number' => $query->app_number]) . '" target="_blank">' . $name. '</a>';  
            })
            ->addColumn('type', function ($query) {
                $type = ($query->applicant_role) ? $query->applicant_role : '';
                return $type;
            })
            ->addColumn('sticker_category', function ($query) {
                $sticker_category = ($query->sticker_category) ? $query->sticker_category : '';
                return $sticker_category;
            })
            ->addColumn('glass_type', function ($query) {
                $glass_type = ($query->glass_type) ? $query->glass_type : '';
                return $glass_type;
            })
            ->addColumn('vehicle_name', function ($query) {
                $vehicle_name = ($query->vehicle_name) ? $query->vehicle_name : '';
                return $vehicle_name;
            })
            ->addColumn('phone', function ($query) {
                $phone = ($query->phone) ? $query->phone : '';
                return $phone;
            })
            ->addColumn('rank_name', function ($query) {
                $rank_name = ($query->rank_name) ? $query->rank_name : '';
                return $rank_name;
            })
            ->addColumn('applicant_BA_no', function ($query) {
                $applicant_BA_no = ($query->applicant_BA_no) ? $query->applicant_BA_no : '';
                return $applicant_BA_no;
            })
            ->addColumn('sticker_reg_number', function ($query) {
                $sticker_reg_number = ($query->sticker_reg_number) ? $query->sticker_reg_number : '';
                return $sticker_reg_number;
            })
            ->addColumn('address', function ($query) {
                $address = ($query->address) ? json_decode($query->address, true) : '';
                return $address['present']['flat'] . ', ' . $address['present']['house'] . ', ' . $address['present']['road'] . ', ' . $address['present']['block'] . ', ' . $address['present']['area'] . '.'; 
            })
            ->addColumn('approval_count', function ($query) {
                $approval_count = ($query->approval_count) ? $query->approval_count : '';
                if($approval_count==1){
                    return '1st time';
                }elseif($approval_count>=2){
                    return '2nd time';
                }else{
                    return "None"; 
                }  
            })
            ->with('sum_balance', $query->sum('credit'))   
            ->rawColumns(['name', 'type', 'sticker_category', 'create_at', 'created_by', 'credit','vehicle_name','glass_type','phone','rank_name','applicant_BA_no','sticker_reg_number','address'])
            ->toJson();
    }
}
