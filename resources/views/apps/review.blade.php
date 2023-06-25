@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')

<div class="content-area" id="review-content">
  <div id="action-bar">
    <ul>
      <li>
        <button  id='' data-toggle="modal" data-target="#myApproveModal" class="btn btn-success"><i class="fas fa-check"></i>  Approve</button>
      </li>
      <li>
       <button data-number="{{$app->app_number}}" id='issue_sticker' data-toggle="modal" data-target=" #myIssueModal"  class="btn btn-success"><i class="fas fa-check-circle"></i> Issue</button>
     </li>
     <li>
      <a data-number="{{$app->app_number}}" href="{{url('/application/edit')}}/{{$app->app_number}}" id='edit_App' style="color: #fff;" class="btn btn-info"><i class="far fa-edit"></i> Edit</a>
    </li>
    <li>
      <button data-number="{{$app->app_number}}" id='notify_user' data-toggle="modal" data-target=" #notify_user_modal"  class="btn btn-info"><i class="far fa-bell"></i> Notify</button>
    </li>
    <li>
      <button data-number="{{$app->app_number}}" id='forward_ps' class="btn btn-info"><i class="fas fa-forward"></i> Forward To PS</button>

    </li>
    <li>
      <button data-id="{{$app->id}}" id='undo_app' class="btn btn-info"><i class="fas fa-undo"></i> Undo</button>

    </li>           
    <li>
      <button data-number="{{$app->app_number}}" id='' data-toggle="modal" data-target="#myRejectModal" class="btn btn-warning">Update</button>
    </li>
      <li>
        <button data-number="{{$app->id}}"  data-toggle="modal" data-target="#holdApplicationModal" class="btn btn-info" title="Hold the Application"><i class="fas fa-pause"></i> Hold</button>
      </li>
    <li>
      <button data-number="{{$app->app_number}}" id='delete_App'  class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
    </li>

    <li>
      <button data-number="{{$app->app_number}}" id='print_App' data-logo="{{asset('assets/images/LogoS1.png')}}" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
    </li>
  </ul>
</div>
<div class="container-fluid" id="app-review">

 <div class="row app-section">
  @if( $stickerPrice==0 && $app->sticker_category=='E')
   <div class="col-md-12">
     <div class="alert alert-danger" role="alert">
       <strong>Alert</strong> Invalid Vehicle Type / Sticker Type.
     </div>
   </div>
   @endif
  <div class="col-md-12">
    <h5 class="text-center py-2 heading-bg">Application Summary</h5>
  </div>
  @if(!empty($app->app_status))
  <div class="col-md-3">
    <span>Status</span>
  </div>
  <div class="col-md-9 app_status_wrapper">
   <span style="color: red;" id="app_status">
    @if ($app->retake == 2 && $app->app_status == 'updated')
        Re-take
	@else
		{{ $app->app_status != 'updated' ? $app->app_status : 'updated' }}	
    @endif
     
  </span>
 </div>
 @endif
 @if(!empty($app->sticker_category))
 <div class="col-md-3">
  <span>Sticker Type</span>
</div>
<div class="col-md-9">
  <span>{{$app->sticker_category}}</span>
</div>
@endif
@if(!empty($app->vehicleSticker->sticker_number))
<div class="col-md-3">
  <span>Sticker No.</span>
</div>
<div class="col-md-9">
  <span>{{$app->vehicleSticker->sticker_number}}</span>
</div>
@endif

  @if(!empty($app->applicationNotify->sticker_delivery_date))
    @if ($app->app_status != 'pending' && $app->app_status != 'updated')
    <div class="col-md-3">
      <span>Delivery Date</span>
    </div>
    <div class="col-md-9">
      <span>{{ date('d-m-Y',strtotime($app->applicationNotify->sticker_delivery_date)) }}</span>
    </div>

  @endif
  @endif

@if(!empty($app->vehicleSticker->issue_date))
<div class="col-md-3">
  <span>Sticker Issue Date</span>
</div>
<div class="col-md-9">
  <span>{{ date('d-m-Y',strtotime($app->vehicleSticker->issue_date)) }} </span>
</div>
@endif
@if(!empty($app->applicant->user_name))
<div class="col-md-3">
  <span>User Name</span>
</div>
<div class="col-md-9">
  <span>{{$app->applicant->user_name}}</span>
</div>
@endif
</div>

<div class="row app-section">
  <div class="col-md-12">
    <h5 class="text-center py-2 heading-bg">Applicant Details</h5>
  </div>
  <div class="col-md-3">
    <span>Applicant Full Name</span>
  </div>
  <div class="col-md-5">
    <span>{{$app->applicant->name}}</span>
  </div>
  <div class="col-md-4 py-1" style="position: relative;border:none;">
    @if(isset($app->applicant->applicantDetail))
    <img id="applicant_photo" src="{{url('/')}}{{$app->applicant->applicantDetail->applicant_photo}}" class="img-fluid preview-img-review" style="position: absolute; top: 0px; right: 15px; z-index: 2;cursor: pointer;" height="150" width="150" alt="{{$app->applicant->name}}" data-toggle="modal" data-target="#applicantPhotoModal">
    @endif

  </div>
  <div class="col-md-3">
    <span>Father/Husband's Name</span>
  </div>
  <div class="col-md-9">
    <span>
      @if(isset($app->applicant->applicantDetail))
      {{isset($app->applicant->applicantDetail->father_name) ? $app->applicant->applicantDetail->father_name : $app->applicant->applicantDetail->husband_name}}
      @else
      -
      @endif
    </span>
  </div>  

  @if(!empty($app->applicant->applicantDetail->applicant_BA_no))
  <div class="col-md-3">
    <span>BA No</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->applicant_BA_no}}
    </span>
  </div>  
  @endif    
  @if(!empty($app->applicant->applicantDetail->rank->name))
  <div class="col-md-3">
    <span>Rank</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->rank->name}}
    </span>
  </div>  
  @endif
  @if(!empty($app->applicant->applicantDetail->spouseOrParent_BA_no))
  <div class="col-md-3">
    <span>Spouse/Parent BA No</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->spouseOrParent_BA_no}}
    </span>
  </div>  
  @endif

  @if(!empty($app->applicant->applicantDetail->spouseOrParent_Rank))
  <div class="col-md-3">
    <span>Spouse/Parent Rank</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->spouseOrParent_Rank}}
    </span>
  </div>  
  @endif 

  @if(!empty($app->applicant->applicantDetail->is_spouseOrChild))
  <div class="col-md-3">
    <span>Is Applicant Def Person's Spouse/Child?</span>
  </div>
  <div class="col-md-9">
    <span>
      {{!empty($app->applicant->applicantDetail->is_spouseOrChild)?'Yes':''}}
    </span>
  </div>  
  @endif 

  @if(!empty($app->applicant->applicantDetail->spouseOrParent_Name))
  <div class="col-md-3">
    <span>Spouse/Parent Name</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->spouseOrParent_Name}}
    </span>
  </div>  
  @endif
  @if(!empty($app->applicant->applicantDetail->spouseOrParent_Unit))
  <div class="col-md-3">
    <span>Spouse/Parent Unit</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->spouseOrParent_Unit}}
    </span>
  </div>  
  @endif 
  @if(!empty($app->applicant->applicantDetail->profession))
  <div class="col-md-3">
    <span>Profession</span>
  </div>
  <div class="col-md-9">
    <span>

      {{ $app->applicant->applicantDetail->profession }}


    </span>
  </div>
  @endif
  @if(!empty($app->applicant->applicantDetail->company_name))
  <div class="col-md-3">
    <span>Company Name</span>
  </div>
  <div class="col-md-9">
    <span>
      {{ $app->applicant->applicantDetail->company_name}}
    </span>
  </div>
  @endif
  @if(!empty($app->applicant->applicantDetail->designation))
  <div class="col-md-3">
    <span>Designation</span>
  </div>

  <div class="col-md-9">
    <span>


      {{$app->applicant->applicantDetail->designation}}


    </span>
  </div>
  @endif

  @if(isset($app->applicant->applicantDetail->address))
  <?php $app_address = json_decode($app->applicant->applicantDetail->address, true);   ?>
  @endif  


  <div class="col-md-3">                            
    <p>Address</p>
  </div>
  
  <div class="col-md-9"> 

    <div class="row"> 
      @if(!empty($app_address['office']['o_flat'])&&!empty($app_address['office']['o_house'])&&!empty($app_address['office']['o_road'])&&!empty($app_address['office']['o_block'])&&!empty($app_address['office']['o_area'])) 
      <div class="col-md-4 asaddress-type">                     
        <div class="sta_address">
          <p class="address-title office">Office Address</p>
          <div class="office_address">
            <span><b>Flat</b>: {{$app_address['office']['o_flat'] }}</span> <br>
            <span><b>House</b>: {{$app_address['office']['o_house'] }}</span><br>
            <span><b>Road</b>: {{$app_address['office']['o_road'] }}</span><br>
            <span><b>Block</b>: {{$app_address['office']['o_block'] }}</span><br>
            <span><b>Area</b>: {{$app_address['office']['o_area'] }}</span>
          </div> 
        </div>                              
      </div>
      @endif 

      
      @if(!empty($app_address['present']['flat'])&&!empty($app_address['present']['house'])&&!empty($app_address['present']['road'])&&!empty($app_address['present']['block'])&&!empty($app_address['present']['area']))  
      <div class="col-md-4 asaddress-type">   
        <div class="sta_address">
          <p class="address-title present">Present Address</p>
          <div class="present_address">

            <span><b>Flat</b>: {{$app_address['present']['flat'] }}</span><br>
            <span><b>House</b>: {{$app_address['present']['house'] }}</span><br>
            <span><b>Road</b>: {{$app_address['present']['road'] }}</span><br>
            <span><b>Block</b>: {{$app_address['present']['block'] }}</span><br>
            <span><b>Area</b>: {{$app_address['present']['area'] }}</span>
          </div>  
        </div>
      </div>
      @endif



      @if(!empty($app_address['permanent']['p_flat'])&&!empty($app_address['permanent']['p_house'])&&!empty($app_address['permanent']['p_road'])&&!empty($app_address['permanent']['p_block'])&&!empty($app_address['permanent']['p_area']))                              
      <div class="col-md-4 asaddress-type"> 
        <div class="sta_address">
          <p class="address-title permanent">Permanent Address</p>
          <div class="permanet_address">
            <span><b>Flat</b>: {{$app_address['permanent']['p_flat'] }}</span><br>
            <span><b>House</b>: {{$app_address['permanent']['p_house'] }}</span><br>
            <span><b>Road</b>: {{$app_address['permanent']['p_road'] }}</span><br>
            <span><b>Block</b>: {{$app_address['permanent']['p_block'] }} </span><br>
            <span><b>Area</b>: {{$app_address['permanent']['p_area'] }} </span>
          </div>
        </div>
      </div>
      @endif

    </div>
  </div>
  
  <div class="col-md-3">
    <span>Residence Type</span>
  </div>
  <div class="col-md-9">
    <span>
      {{isset($app->applicant->applicantDetail->residence_type) ? $app->applicant->applicantDetail->residence_type : '-' }}
    </span>
  </div> 
  <div class="col-md-3">
    <span>National ID</span>
  </div>
  <div class="col-md-9">
    <span>
      {{isset($app->applicant->applicantDetail->nid_number) ? $app->applicant->applicantDetail->nid_number : '-' }}
    </span>
  </div>
  <div class="col-md-3">
    <span>Mobile No.</span>
  </div>
  <div class="col-md-9">
    <span>
      {{isset($app->applicant->phone) ? $app->applicant->phone : '-' }}
    </span>
  </div>
  <div class="col-md-3">
    <span>Email</span>
  </div>
  <div class="col-md-9">
    <span>
      {{isset($app->applicant->email) ? $app->applicant->email : '-' }}

    </span>
  </div>

  <div class="col-md-3">
    <span>Tin</span>
  </div>
  <div class="col-md-9">
    <span>
      {{isset($app->applicant->applicantDetail->tin) ? $app->applicant->applicantDetail->tin : '-' }}
    </span>
  </div>
  @if(!empty($app->applicant->applicantDetail->no_sticker_to_self_family))
  <div class="col-md-3">
    <span>Number Of Sticker allocated to applicant/applicant's family 2018</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->no_sticker_to_self_family}}
    </span>
  </div>
  @endif
  @if(!empty($app->applicant->applicantDetail->allocated_current_sticker_type))
  <div class="col-md-3">
    <span>Currently allocated Sticker Types</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->allocated_current_sticker_type}}
    </span>
  </div>
  @endif
  @if(!empty($app->applicant->applicantDetail->allocated_current_sticker_no))
  <div class="col-md-3">
    <span>Currently allocated Sticker No</span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->applicant->applicantDetail->allocated_current_sticker_no}}
    </span>
  </div>
  @endif
  @if(!empty($app->remark))
  <div class="col-md-3">
    <span>Applicant Remarks  </span>
  </div>
  <div class="col-md-9">
    <span>
      {{$app->remark}}
    </span>
  </div>
  @endif
</div>
<div class="row app-section mt-3">
  <div class="col-md-12">
    <h5 class="text-center py-2 heading-bg">Vehicle Details</h5>
  </div>
  <div class="col-md-3">
    <span>Vehicle Type</span>
  </div>
  <div class="col-md-9">
    <span>{{!empty($app->vehicleinfo->vehicleType->name)?$app->vehicleinfo->vehicleType->name:''}}</span>
  </div>
  <div class="col-md-3">
    <span>Vehicle Glass Type</span>
  </div>
  <div class="col-md-9">
    <span>{{ucfirst($app->glass_type)}}</span>
  </div>
  <div class="col-md-3">
    <span>Vehicle Registration No.</span>
  </div>
  <div class="col-md-9">
    <span>{{!empty($app->vehicleinfo->reg_number)?$app->vehicleinfo->reg_number:''}}</span>
  </div>
  <div class="col-md-3">
    <span>
      Owner is company?
    </span>
  </div>
  <div class="col-md-9">
    <span>
      {{!empty($app->vehicleowner->company_name)?'Yes':'No' }}
    </span>
  </div>  
  @if(!empty($app->vehicleowner->company_name))
  <div class="col-md-3">
    <span>Company Name</span>
  </div>
  <div class="col-md-9">
   <span>{{!empty($app->vehicleowner->company_name) ? $app->vehicleowner->company_name : '' }}</span>
 </div>
 <div class="col-md-3">
  <p>Company Address</p>
</div>
<div class="col-md-9">
 <?php $com_address = json_decode($app->vehicleowner->company_address, true);   ?>
 <span>House: {{$com_address['house'] }}</span><br>
 <span>Road: {{$com_address['road'] }}</span><br>
 <span>Block: {{$com_address['block'] }}</span><br>
 <span>Area: {{$com_address['area'] }}</span>
</div>
@endif
<div class="col-md-3">
  <span>Owner Name</span>
</div>
<div class="col-md-9">
  <span>
    {{isset($app->vehicleowner->owner_name) ? $app->vehicleowner->owner_name : '-' }}
  </span>
</div>
<div class="col-md-3">
  <span>Tax Paid Upto</span>
</div>
<div class="col-md-9">
  <span>
    {{isset($app->vehicleinfo->tax_token_validity) ? Carbon\Carbon::parse($app->vehicleinfo->tax_token_validity)->format('d-m-Y') : '-' }}

  </span>
</div>
<div class="col-md-3">
  <span>Loan Taken?</span>
</div>
<div class="col-md-9">
  <span>
    {{!empty($app->vehicleinfo->loan_taken) ? 'Yes' : 'No' }}

  </span>
</div>


<div class="col-md-3">
  <span>Fitness Validity</span>
</div>
<div class="col-md-9">
  <span>
    {{isset($app->vehicleinfo->fitness_validity) ? Carbon\Carbon::parse($app->vehicleinfo->fitness_validity)->format('d-m-Y') : '-' }}
  </span>
</div>


<div class="col-md-3">
  <span>Insurance Validity</span>
</div>
<div class="col-md-9">
  <span>
    {{isset($app->vehicleinfo->insurance_validity) ? Carbon\Carbon::parse($app->vehicleinfo->insurance_validity)->format('d-m-Y') : '-' }}
  </span>
</div>


<div class="col-md-3">
  <span>Necessity of Using Station HQ </span>
</div>
<div class="col-md-9">
  <span>
    {{isset($app->vehicleinfo->necessity_to_use) ? $app->vehicleinfo->necessity_to_use : '-' }}
  </span>
</div>

</div>

<div class="row app-section mt-3">
  <div class="col-md-12">
    <h5 class="text-center py-2 heading-bg">Driver Details</h5>
  </div>
  @if(!empty($app->driverinfo->driver_is_owner) && $app->driverinfo->driver_is_owner== '1')


  <div class="col-md-3">
    <span>Vehicle is self driven?</span>
  </div>
  <div class="col-md-9">
    <span>
     Yes
   </span>
 </div>
 <div class="col-md-3">
  <span>Driver's Name</span>
</div>
<div class="col-md-4" style="border: none;">
  <span>
    -
  </span>
</div>
<div class="col-md-5" style="position: relative; border: none;">
  <img id="driver_photo" src="{{url('/')}}{{!empty($app->applicant->applicantDetail->applicant_photo) ? $app->applicant->applicantDetail->applicant_photo:''}}" class="img-fluid preview-img-review" alt="" style="position: absolute; top: 15px; right: 15px; z-index: 2;cursor: pointer;" height="150" width="150" data-toggle="modal" data-target="#DriverPhotoModaldata" >
</div>
<div class="col-md-3">
  <p>Present Address</p>
</div>

<div class="col-md-9">
  -
</div>
<div class="col-md-3">
  <p>Permanent Address</p>
</div>
<div class="col-md-9">
  -
</div>

<div class="col-md-3">
  <span>NID No.</span>
</div>
<div class="col-md-9">
  <span>
    -
  </span>
</div>
@elseif(empty($app->driverinfo->driver_is_owner))
<div class="col-md-3">
  <span>Vehicle is self driven?</span>
</div>
<div class="col-md-9">
  <span>
    No
  </span>

</div>
<div class="col-md-3">
  <span>Driver's Name</span>
</div>
<div class="col-md-4" style="border: none;">
  <span>
    {{isset($app->driverinfo->name) ? $app->driverinfo->name : '-' }}
  </span>
</div>
<div class="col-md-5"  style="position: relative;">
  <img id="driver_photo" src="{{url('/')}}{{!empty($app->driverinfo->photo)?$app->driverinfo->photo:''}}" class="img-fluid preview-img-review" alt="" style="position: absolute; top: 15px; right: 15px; z-index: 2;cursor: pointer;" height="150" width="150" data-toggle="modal" data-target="#DriverPhotoModaldata" >
</div>
@if(isset($app->driverinfo->address) && isset($app->driverinfo->address)!='')

<?php  $driver_address = json_decode($app->driverinfo->address, true);   ?>
<div class="col-md-3">
  <p>Address</p>
</div>
<div class="col-md-9">
  <div class="row"> 
    <div class="col-md-4 asaddress-type">                           
      <div class="sta_address">

        <p class="address-title present">Prersent Address</p>
        <div class="present_address">
          <span>House: {{!empty($driver_address['present']['house']) ? $driver_address['present']['house'] : ''}}</span> <br>
          <span>Road: {{!empty($driver_address['present']['road']) ? $driver_address['present']['road'] : ''}}</span> <br>
          <span>Block: {{!empty($driver_address['present']['block']) ? $driver_address['present']['block'] : ''}}</span> <br>
          <span>Area: {{!empty($driver_address['present']['area']) ? $driver_address['present']['area'] : ''}}</span>
        </div> 
      </div> 
    </div>
    
    <div class="col-md-4 asaddress-type">                           
      <div class="sta_address">
        <p class="address-title permanent">Permanent Address</p>
        <div class="permanant_address">
          <span>House: {{!empty($driver_address['permanent']['p_house']) ? $driver_address['permanent']['p_house'] : '-' }}</span> <br>
          <span>Road: {{!empty($driver_address['permanent']['p_road']) ? $driver_address['permanent']['p_road'] : '-'}}</span> <br>
          <span>Block: {{!empty($driver_address['permanent']['p_block']) ? $driver_address['permanent']['p_block'] : '-'}}</span> <br>
          <span>Area: {{!empty($driver_address['permanent']['p_area']) ? $driver_address['permanent']['p_area'] : '-'}}</span>
        </div> 
      </div> 
    </div>

  </div>
</div>
@endif





<div class="col-md-3">
  <span>NID No.</span>
</div>
<div class="col-md-9">
  <span>
    {{isset($app->driverinfo->nid_number) ? $app->driverinfo->nid_number : '-' }}
  </span>
</div>
@endif

</div>


<div class="row app-section doc-section mt-3">
  <div class="col-md-12">
    <h5 class="text-center py-2 heading-bg">Documents</h5>
  </div>
  <div class="col-md-4">
    <span>Applicant NID Copy</span>
  </div>
  <div class="col-md-1">
    @if(isset($app->applicant->applicantDetail->nid_photo) && !empty($app->applicant->applicantDetail->nid_photo))
    <button type="button"  class="btn btn-info doc_img_prev" data-toggle="modal"  data-target="#nid1-copy">
      View
    </button>

    <div class="modal fade" id="nid1-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Applicant NID Copy
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding:0;">
            <img id="docImg1" src="{{url('/')}}{{$app->applicant->applicantDetail->nid_photo}}" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </div>


    @else
    -
    @endif

  </div>



  <div class="col-md-4 offset-md-1">
    <span>Applicant Def ID Copy</span>
  </div>
  <div class="col-md-2">
    @if(!empty($app->applicant->applicantDetail->defIdCopy) && !empty($app->applicant->applicantDetail->defIdCopy))
    <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#defID-copy">
      View
    </button>
    <div class="modal fade" id="defID-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Applicant Def ID Copy
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding:0;">
          <img id="docImg2" src="{{url('/')}}{{$app->applicant->applicantDetail->defIdCopy}}" class="img-fluid" alt="">

        </div>
        </div>
      </div>
    </div>
    @else
    -
    @endif
  </div>
  <div class="col-md-4">
    <span>Vehicle Registration Copy</span>
  </div>
  <div class="col-md-1">
    @if(isset($app->vehicleinfo->reg_cert_photo) && !empty($app->vehicleinfo->reg_cert_photo))
    <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid3-copy">
      View
    </button>
    <div class="modal fade" id="nid3-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Vehicle Registration Copy
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding:0;">
         
          <img id="docImg3" src="{{url('/')}}{{$app->vehicleinfo->reg_cert_photo}}" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </div>

    @else
    -
    @endif
  </div>

  <div class="col-md-4 offset-md-1">
    <span>Applicant's Photo</span>
  </div>
  <div class="col-md-2">
    @if(isset($app->applicant->applicantDetail->applicant_photo) && !empty($app->applicant->applicantDetail->applicant_photo))
    <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid4-copy">
      View
    </button>
    <div class="modal fade" id="nid4-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Applicant's Photo
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding:0;">
            <img id="docImg3" src="{{url('/')}}{{$app->applicant->applicantDetail->applicant_photo}}" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </div>

    @else
    -
    @endif
  </div>

  <div class="col-md-4">
    <span>Tax Token Copy</span>
  </div>

  <div class="col-md-1">
    @if(isset($app->vehicleinfo->tax_token_photo) && !empty($app->vehicleinfo->tax_token_photo))
    <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid5-copy">
      View
    </button>
    <div class="modal fade" id="nid5-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Tax Token Copy
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding:0;">
           <img id="docImg4" src="{{url('/')}}{{$app->vehicleinfo->tax_token_photo}}" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </div>
    @else
    -
    @endif
  </div>

  <div class="col-md-4 offset-md-1">
    <span>Fitness Certificate Copy</span>
  </div>
  <div class="col-md-2">
   @if(isset($app->vehicleinfo->fitness_cert_photo) && !empty($app->vehicleinfo->fitness_cert_photo))
   <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid6-copy">
    View
  </button>
  <div class="modal fade" id="nid6-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          Fitness Certificate Copy
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding:0;">
          <img id="docImg5" src="{{url('/')}}{{$app->vehicleinfo->fitness_cert_photo}}" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>

  @else
  -
  @endif
</div>

<div class="col-md-4">
  <span>Insurance Certificate Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->vehicleinfo->insurance_cert_photo) && !empty($app->vehicleinfo->insurance_cert_photo))

 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid7-copy">
  View
</button>
<div class="modal fade" id="nid7-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Insurance Certificate Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
         <img id="docImg6" src="{{url('/')}}{{$app->vehicleinfo->insurance_cert_photo}}" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>


@else
-
@endif
</div>

<div class="col-md-4 offset-md-1">
  <span>Civil Service ID Copy</span>
</div>
<div class="col-md-2">
 @if(isset($app->document->civil_service_id) && !empty($app->document->civil_service_id))

 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid8-copy">
  View
</button>
<div class="modal fade" id="nid8-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Civil Service ID Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
      <img id="docImg7" src="{{url('/')}}{{$app->document->civil_service_id}}" class="img-fluid" alt="">
        
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div>

<div class="col-md-4">
  <span>Proyash School Certificate Copy</span>
</div>
<div class="col-md-1">
  @if(isset($app->document->school_cert) && !empty($app->document->school_cert))

  <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid9-copy">
    View
  </button>

  <div class="modal fade" id="nid9-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          Proyash School Certificate Copy
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding:0;">
          <img id="docImg8" src="{{url('/')}}{{$app->document->school_cert}}" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </div>
  @else
  -
  @endif
</div>

<div class="col-md-4 offset-md-1">
  <span>Marriage Certificate Copy</span>
</div>
<div class="col-md-2">
 @if(isset($app->document->marriage_cert) && !empty($app->document->marriage_cert))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid10-copy">
  View
</button>
<div class="modal fade" id="nid10-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Marriage Certificate Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
        
       <img id="docImg9" src="{{url('/')}}{{$app->document->marriage_cert}}" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div>

<div class="col-md-4">

  <span>Driver NID Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->driverinfo->nid_photo) && !empty($app->driverinfo->nid_photo))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid11-copy">
  View
</button>
<div class="modal fade" id="nid11-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Driver NID Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
        <img id="docImg10"  src="{{url('/')}}{{$app->driverinfo->nid_photo}}" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div>

<div class="col-md-4 offset-md-1">
  <span>Driving License Copy</span>
</div>
<div class="col-md-2">
 @if(isset($app->driverinfo->licence_photo) && !empty($app->driverinfo->licence_photo))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid12-copy">
  View
</button>

<div class="modal fade" id="nid12-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Driving License Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
     
        <img id="docImg11"src="{{url('/')}}{{$app->driverinfo->licence_photo}}" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>
@else
-
@endif
</div>

<div class="col-md-4 ">
  <span>Job Certificate Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->document->job_cert) && !empty($app->document->job_cert))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid13-copy">
  View
</button>
<div class="modal fade" id="nid13-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Job Certificate Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
      <img id="docImg12"src="{{url('/')}}{{$app->document->job_cert}}" class="img-fluid" alt="">
       
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div> 


<div class="col-md-4 offset-md-1">
  <span>House Owner Certificate Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->document->house_owner_cert) && !empty($app->document->house_owner_cert))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid14-copy">
  View
</button>
<div class="modal fade" id="nid14-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        House Owner Certificate Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">\
        <img id="docImg13" src="{{url('/')}}{{$app->document->house_owner_cert}}" class="img-fluid" alt="">
        
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div> 

<div class="col-md-4 ">
  <span>Ward Commissioner Certificate Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->document->ward_comm_cert) && !empty($app->document->ward_comm_cert))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid15-copy">
  View
</button>
<div class="modal fade" id="nid15-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Ward Commissioner Certificate Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
        <img id="docImg14" src="{{url('/')}}{{$app->document->ward_comm_cert}}" class="img-fluid" alt="">

        
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div>

<div class="col-md-4 offset-md-1">
  <span>Autorised Certificate Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->document->auth_cert) && !empty($app->document->auth_cert))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid16-copy">
  View
</button>
<div class="modal fade" id="nid16-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Autorised Certificate Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
        <img id="docImg15" src="{{url('/')}}{{$app->document->auth_cert}}" class="img-fluid" alt="">
       
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div> 

<div class="col-md-4 ">
  <span>Father Testimonial Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->document->father_testm) && !empty($app->document->father_testm))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid17-copy">
  View
</button>
<div class="modal fade" id="nid17-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Father Testimonial Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
      
      <img id="docImg16" src="{{url('/')}}{{$app->document->father_testm}}" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div>

<div class="col-md-4 offset-md-1">
  <span>Mother Testimonial Copy</span>
</div>
<div class="col-md-1">
 @if(isset($app->document->mother_testm) && !empty($app->document->mother_testm))
 <button type="button" class="btn btn-info doc_img_prev" data-toggle="modal" data-target="#nid18-copy">
  View
</button>
<div class="modal fade" id="nid18-copy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Mother Testimonial Copy
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
      <img id="docImg17" src="{{url('/')}}{{$app->document->mother_testm}}" class="img-fluid" alt="">
        
      </div>
    </div>
  </div>
</div>

@else
-
@endif
</div>

</div>
<div class="row app-section doc-section mt-3">
  <div class="col-md-12">
    <h5 class="text-center py-2  heading-bg">Follow Up</h5>
  </div>
  <table class="table table-bordered table-striped follow-up-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Date</th>
        <th>Status</th>
        <th>Comments</th>
        <th>Notified</th>
        <th>By</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($app->followups) && count($app->followups)>0)
      @foreach($app->followups->sortByDesc('created_at') as $follow_up)
      <tr class="follow-up-row">
        <td>{{$loop->iteration}}</td>
        <td>{{ \Carbon\Carbon::parse($follow_up->created_at)->toDayDateTimeString()}}</td>
        <td>
          {{$follow_up->status}}
        </td>
        <td>{{!empty($follow_up->comment)?$follow_up->comment:''}}</td>
        <td>
          <div class="row justify-content-center">
            <div class="col-md-3">
              @if($follow_up->sms_sent=='success')
              <span style="color: green;" title="sms sent"><i class="fas fa-check"></i></span>
              @elseif($follow_up->sms_sent=='fail')
              <span class="sms-status-replace" hidden></span>
              <span class="sms-failed" style="color: red;" title="sms not sent"><i class="fas fa-times"></i></span>
              <span class="resendSms sms-failed" data-id="{{$follow_up->id}}" style="color:#07adca; cursor: pointer;" title="retry to send"><i class="fas fa-redo-alt"></i></span>
              @endif
            </div>
            <div class="col-md-3">
              @if($follow_up->mail_sent=='success')
              <span style="color: green;" title="mail sent"><i class="fas fa-check"></i></span>
              @elseif($follow_up->mail_sent=='fail')
              <span style="color: red;" title="mail not sent"><i class="fas fa-times"></i></span>
              @endif
            </div>
          </div>

        </td>
        <td>{{$follow_up->updated_by}}</td>
      </tr>  
      @endforeach
      @endif


    </tbody>
  </table>
</div>

</div>
</div>

<!-- Hold Modal-->
<div class="modal fade" id="holdApplicationModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
        <legend style="color:#fff; text-align: center; ">Hold the Application</legend>
        <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
        <div class="row">
            <div class="col-md-12" >


                <textarea style="margin: 10px" class="form-control"  id="holdMessage" placeholder="Enter the hold reason here"></textarea>

            </div>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" data-number="{{$app->id}}" class="btn btn-primary custm-btn" id="confirm-hold">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Hold Modal End-->


<!-- Approve Modal -->

<div class="modal fade" id="myApproveModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
        <legend style="color:#fff; text-align: center; ">Select Delivery Date</legend>
        <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding:0;">
       <div class="row">
        <div class="col-md-4 offset-md-1">
          <label for="" class="label-form"> Sticker Type </label> <span>*</span> <br>
          <small></small>
        </div>
        <div class="col-md-7">
         <select name="sticker_type" id="sticker_type" class="form-control in-form mandatory" required>
          <option  selected disabled value=""> --Select One--</option>
          <?php 
          $stickers=App\StickerCategory::all();
          ?>
          @foreach($stickers as $sticker)
          <option  value="{{$sticker->value}}">{{$sticker->name}}</option>

          @endforeach

        </select>
        <div id="err_msg_sticker_type" class="" style="color:#bd2130;" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_sticker_type"> </span>
        </div>
      </div>
      <div class="col-md-4 offset-md-1">
        <label for="" class="label-form"> Delivery Date </label> <span>*</span> <br>
        <small></small>
      </div>
      <div class="col-md-7">
       <input type="date" id="sticker_delivery_date" value="" name="sticker_delivery_date"  class="form-control in-form" placeholder="" required>
       <div id="err_msg_delDate" class="" style="color:#bd2130;" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_delDate"> </span>
       </div>
     </div>
   </div>

 </div>
 <div class="modal-footer">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
  <button type="submit" data-number="{{$app->app_number}}" class="btn btn-primary custm-btn" id="approve_App">Confirm Approve</button>
</div>
</div>
</div>
</div>
<!-- The Modal -->   
<!-- Reject Modal -->
<div class="modal fade" id="myRejectModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
        <legend style="color:#fff; text-align: center; ">Show Reject Reason</legend>
        <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
        </button>
      </div>
      <div class="modal-body mt-2" style="padding:0;" >
        <div class="row ">
          <div class="col-md-12 ">
            <div class="row funkyradio justify-content-center">
              <div class="funkyradio-primary col-md-4">
                <input type="radio" name="reason_type" id="file_miss_case" checked value="file_miss_case"/>
                <label for="file_miss_case">File Missing/Obscurity</label>
              </div>
              <div class="funkyradio-info col-md-4">
                <input type="radio" name="reason_type" id="custom_case" value="custom_case"/>
                <label for="custom_case">Custom Reason</label>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col" id="mis_matched">
            <form id="reject_file_sms_form">
             <fieldset class="xfieldset">
              <div class="row justify-content-center">
                <div class="col-xs-5">
                 <div>
                  <input type="checkbox" class="attach_file" id="Applicant_Photo" name="Applicant_Photo"
                  value="আবেদনকারীর ছবি" />
                  <label for="Applicant_Photo">Applicant Photo</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Applicant_NID" name="Applicant_NID"
                  value="আবেদনকারীর জাতীয় পরিচয়পত্রের কপি" />
                  <label for="Applicant_NID">Applicant NID</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="def_id" name="def_id"
                  value="আবেদনকারীর সামরিক পরিচয়পত্রের কপি" />
                  <label for="def_id">Applicant Def ID</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Driver_Photo" name="Driver_Photo"
                  value="গাড়ি চালকের ছবি" />
                  <label for="Driver_Photo">Driver Photo</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Driver_NID" name="Driver_NID"
                  value="গাড়ি চালকের জাতীয় পরিচয়পত্রের কপি" />
                  <label for="Driver_NID">Driver NID</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Driver_License_Copy" name="Driver_License_Copy"
                  value="ড্রাইভিং লাইসেন্সের কপি" />
                  <label for="Driver_License_Copy">Driver License </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Father_Testimonial" name="Father_Testimonial"
                  value="পিতার প্রত্যয়নপত্র" />
                  <label for="Father_Testimonial">Father Testimonial </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Mother_Testimonial" name="Mother_Testimonial"
                  value="মাতার প্রত্যয়নপত্র" />
                  <label for="Mother_Testimonial">Mother Testimonial </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Autorised_Certificate" name="Autorised_Certificate"
                  value="কোম্পানীর অনুমোদিত প্রত্যয়নপত্র" />
                  <label for="Autorised_Certificate">Authorised Certificate </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Marriage_Certificate_Copy" name="Marriage_Certificate_Copy"
                  value="বিবাহিত সনদপত্র / সন্তানের জন্ম সনদ / কোরো সনদ"/>
                  <label for="Marriage_Certificate_Copy">Marriage Certificate </label>
                </div>
                  <div>
                    <input type="checkbox" class="attach_file" id="Owner_NID" name="Owner_NID"
                           value="গাড়ির মালিকের জাতীয় পরিচয়পত্র"  />
                    <label for="Owner_NID">Owner NID</label>
                  </div>

              </div>

              <div class="col-xs-5">


                <div>
                  <input type="checkbox" class="attach_file" id="Vehicle_Reg_Copy" name="Vehicle_Reg_Copy"
                  value="গাড়ির রেজিষ্ট্রেশন" />
                  <label for="Vehicle_Reg_Copy">Vehicle Reg </label>
                </div>

                <div>
                  <input type="checkbox" class="attach_file" id="Tax_Token_Copy" name="Tax_Token_Copy"
                  value="গাড়ির ট্যাক্স টোকেন" />
                  <label for="Tax_Token_Copy">Tax Token </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Fitness_Certificate_Copy" name="Fitness_Certificate_Copy"
                  value="গাড়ির ফিটনেস সনদপত্র" />
                  <label for="Fitness_Certificate_Copy">Fitness Certificate </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Insurance_Certificate_Copy" name="Insurance_Certificate_Copy"
                  value="ইন্সুরেন্স সনদপত্র" />
                  <label for="Insurance_Certificate_Copy">Insurance Certificate</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Ward_Commissioner_Certificate" name="Ward_Commissioner_Certificate"
                  value="ওয়ার্ড কমিশনারের সনদপত্র" />
                  <label for="Ward_Commissioner_Certificate">Ward Commissioner Cert.</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="House_Owner_CEO_Certificate" name="House_Owner_CEO_Certificate"
                  value="বাড়ির মালিক / ক্যান্টনমেন্ট বোর্ড  এর সনদপত্র" />
                  <label for="House_Owner_CEO_Certificate">House Owner/CEO Cert.</label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Job_Certificate" name="Job_Certificate"
                  value="চাকুরী সনদপত্র" />
                  <label for="Job_Certificate">Job Certificate </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="Civil_Service_ID" name="Civil_Service_ID"
                  value="বেসামরিক সার্ভিস আইডি কার্ডের কপি" />
                  <label for="Civil_Service_ID">Civil Service ID </label>
                </div>
                <div>
                  <input type="checkbox" class="attach_file" id="School_Certificate" name="School_Certificate"
                  value="স্কুল সার্টিফিকেটের কপি" />
                  <label for="School_Certificate">School Certificate </label>
                </div>
                <div>
                  <input type="checkbox" class="other_sms" id="road-permit" name="other_sms"
                         value="road-permit" />
                  <label for="road-permit">Road Permit</label>
                </div>
                <div>
                  <input type="checkbox" class="other_sms" id="police-verification" name="other_sms"
                         value="police-verification" />
                  <label for="police_verification">Police Verification </label>
                </div>
                <div>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
        <div  hidden id="custom_reason" class="col-md-12">
         <div class="row justify-content-center">
          <div class="col-md-10">
            <form id="reject_sms_form">
              <div class="row justify-content-center">
               <div class="col-md-3 offset-md-1">
                <label for="" class="label-form">SMS Template</label><span>*</span> <br>
                <small></small>
              </div>
              <div class="col-md-7">
               <select name="sms_template select2" data-sms="{{$all_sms}}"
               class="form-control in-form sms_template" >
               <option value="">Select SMS Template</option>
               @if(isset($all_sms) && (count($all_sms) > 0))
               @foreach($all_sms as $sms)
               <option value="{{$sms->id}}">{{$sms->sms_template_name}}</option>
               @endforeach
               @endif
             </select>
           </div>
           <div class="col-md-3 offset-md-1">
            <label for="" class="label-form">Subject</label><span>*</span> <br>
            <small></small>
          </div>
          <div class="col-md-7">
            <input type="text" name="sms_subject"  class="form-control in-form sms_subject" value="">
            <input type="hidden" name="sms_id"  class="form-control in-form sms_id" value="">
          </div> 
          <div class="col-md-3 offset-md-1">
            <label for="" class="label-form">Message</label><span>*</span> <br>
            <small></small>
          </div>
          <div class="col-md-7 mb-4">
            <textarea type="text" rows='5' name="sms_text" class="form-control in-form sms_text"></textarea>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
  <button type="submit" data-number="{{$app->app_number}}" class="btn btn-primary" id="reject_App">Confirm Reject</button>
</div>
</div>
</div>
</div>
<!-- The Issue Modal -->

<div class="modal fade" id="myIssueModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
      <legend style="color:#fff; text-align: center; ">Issue Vehicle Sticker</legend>
      <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
     </button>
   </div>
   <form id="issueSticker_Form">
    {{csrf_field()}}
    <div class="modal-body">

      <div class="row">
       <div class="col-md-4 offset-md-1">
        <label for="" class="label-form">Applicant Name</label><span></span> <br>
        <small></small>
      </div>
      <div class="col-md-7">
        {{$app->applicant->name}}
      </div>
      <div class="col-md-4 offset-md-1">
        <label for="" class="label-form">Phone Number</label><span></span> <br>
        <small></small>
      </div>
      <div class="col-md-7">
        {{$app->applicant->phone}}
      </div>  <div class="col-md-4 offset-md-1">
        <label for="" class="label-form">Sticker Type</label><span></span> <br>
        <small></small>
      </div>
      <div class="col-md-7">
        {{$app->sticker_category}}
      </div>
      <div class="col-md-4 offset-md-1">
        <label for="" class="label-form">Vehicle Type</label><span></span> <br>
        <small></small>
      </div>
      <div class="col-md-7">
       {{!empty($app->vehicleinfo->vehicleType->name)?$app->vehicleinfo->vehicleType->name:''}}
     </div>
     <div class="col-md-4 offset-md-1">
      <label for="" class="label-form">Vehicle Reg. Number</label><span></span> <br>
      <small></small>
    </div>
    <div class="col-md-7">
      {{!empty($app->vehicleinfo->reg_number)?$app->vehicleinfo->reg_number:''}}
    </div>
    <div class="col-md-4 offset-md-1">
      <label for="" class="label-form">Sticker Number</label> <span style="color:red;">*</span> <br>
      <small></small>
    </div>
    <div class="col-md-7">
      <input type="text" id="sticker_number" value="" name="sticker_number"  class="form-control in-form" placeholder="" required>
    </div>
    <div class="col-md-4 offset-md-1">
      <label for="" class="label-form">Sticker Issue Date</label> <span style="color:red;">*</span> <br>
      <small></small>
    </div>
    <div class="col-md-7">
      <input type="date" id="issue_sticker_date" value="" name="issue_sticker_date"  class="form-control in-form" placeholder="" required>

    </div>

    <?php
    $exp_date=null;
    if(!empty($app->stickerCategory->duration)){
      $current_year_lastdate =date('Y-m-d', strtotime('12/31'));
      $exp_date = date('Y-m-d', strtotime('+'.($app->stickerCategory->duration-1).'year', strtotime($current_year_lastdate)));
    }  
    ?>
    <div class="col-md-4 offset-md-1">
      <label for="" class="label-form">Expired Date</label> <span style="color:red;">*</span> <br>
      <small></small>
    </div>
    <div class="col-md-7">
      <input type="date" id="sticker_exp_date" value="{{!empty( $exp_date )? $exp_date :''}}" name="sticker_exp_date"  class="form-control in-form" placeholder="" required readonly style=" cursor:no-drop;">
      <input type="hidden" value="{{$app->app_number}}" name="app_number"  class="form-control in-form" placeholder="">
    </div>
    <div class="col-md-4 offset-md-1">
      <label for="" class="label-form">Amount</label> <span style="color:red;">*</span> <br>
      <small></small>
    </div>
    <div class="col-md-7">
      <input type="text" value="{{$stickerPrice}}" name="amount" id="amount"  class="form-control in-form" placeholder="" required readonly style=" cursor:no-drop;">
    </div>
    <div class="col-md-4 offset-md-1">
      <label class="label-form">Issue Case </label> <span style="color: red;">*</span><small></small>
    </div>
    <div class="col-md-7">
      <div class="row funkyradio">
        <div class="funkyradio-primary col-md-4">
          <input type="radio" name="issue_type" id="normal_case" checked value="normal"/>
          <label for="normal_case">Normal</label>
        </div>
        <div class="funkyradio-warning col-md-4">
          <input type="radio" name="issue_type" id="special_case" value="special"/>
          <label for="special_case">Special</label>
        </div>
      </div>
<!--       <input type="checkbox"  class="form-group chb issue_type" name="issue_type" value="normal"> &nbsp; <label> Normal </label> &nbsp;
  <input type="checkbox"  class="form-group chb issue_type" id="special" name="issue_type" value="special">&nbsp; <label> Special </label> -->
</div>
<div class="col-md-4 offset-md-1 special_case" hidden>
  <label for="" class="label-form">Discount Amount</label> <span style="color:red;">*</span> <br>
  <small></small>
</div>
<div class="col-md-7 special_case" hidden>
  <input type="number" id='discount_amount' value="" name="discount_amount"  class="form-control in-form special_data" placeholder="" required>
</div>
<div class="col-md-4 offset-md-1">
  <label for="" class="label-form">Total Amount</label> <span style="color:red;">*</span> <br>
  <small></small>
</div>
<div class="col-md-7" >
  <input type="number" value="{{$stickerPrice}}" name="total_amount"  class="form-control in-form" id="total_amount" placeholder="" required readonly style=" cursor:no-drop;">
</div>
<div class="col-md-4 offset-md-1 special_case" hidden>
  <label for="" class="label-form">Comment</label> <span style="color:red;">*</span> <br>
  <small></small>
</div>
<div class="col-md-7 special_case" hidden>
  <textarea value="" name="comment"  class="form-control in-form special_data" placeholder="" required></textarea>
</div>
</div>
</div>     

<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary" id="confirm_sticker">Confirm Sticker</button>
</div>
</form>
</div>
</div>
</div>     
<!-- Notify Modal -->
<div class="modal fade" id="notify_user_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
      <legend style="color:#fff; text-align: center; ">Send Sms To Notify User </legend>
      <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
     </button>
   </div>
   <form id="sendSms_Form">
    {{csrf_field()}}
    <div class="modal-body">

     <div class="row">

       <div class="col-md-4 offset-md-1">
        <label for="" class="label-form">SMS Template</label><span>*</span> <br>
        <small></small>
      </div>
      <div class="col-md-7">
       <select name="sms_template select2" data-sms="{{$all_sms}}" id="sms_template"
       class="form-control in-form sms_template" >
       <option value="" selected="">Select SMS Template</option>
       @if(isset($all_sms) && (count($all_sms) > 0))
       @foreach($all_sms as $sms)
       <option value="{{$sms->id}}">{{$sms->sms_template_name}}</option>
       @endforeach
       @endif
     </select>
   </div>
   <div class="col-md-4 offset-md-1">
    <label for="" class="label-form">Subject</label><span>*</span> <br>
    <small></small>
  </div>
  <div class="col-md-7">
    <input type="text" name="sms_subject" id="sms_subject" class="form-control in-form sms_subject" value="">
  </div> 
  <div class="col-md-4 offset-md-1">
    <label for="" class="label-form">Message</label><span>*</span> <br>
    <small></small>
  </div>
  <div class="col-md-7">
    <textarea type="text" rows='5' id="sms_text"  name="sms_text" class="form-control in-form sms_text" ></textarea>
  </div>
  <!-- <input type="hidden" name="app_phone_num" id="app_phone_num" class="form-control in-form" value="{{$app->applicant->phone}}"> -->
  <input type="hidden" name="app_email" id="app_email" class="form-control in-form" value="{{$app->applicant->email}}">
  <input type="hidden"  name="app_id" id="app_id" class="form-control in-form" value="{{$app->id}}">
</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
  <button type="submit" class="btn btn-primary" id="confirm_sms">Send SMS</button>
</div>
</form>
</div>
</div>
</div>


<!-- Applicant Photo --> 
<div class="modal fade" id="applicantPhotoModal" tabindex="-1" role="dialog" aria-labelledby="modal1Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        Applicant's Photo
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

        </button>

      </div>
      <div class="modal-body" style="padding:0;">
        <img src="{{!empty($app->applicant->applicantDetail->applicant_photo)?url($app->applicant->applicantDetail->applicant_photo):''}}" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>

<!-- End App Photo Modal --> 
<!-- Driver Photo --> 
<div class="modal fade" id="DriverPhotoModal" tabindex="-1" role="dialog" aria-labelledby="modal1Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        Driver's Photo
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

        </button>

      </div>
      <div class="modal-body" style="padding:0;">
        @if(!empty($app->driverinfo->photo) && empty($app->driverinfo->driver_is_owner))
        <img src="{{!empty($app->driverinfo->photo)?url($app->driverinfo->photo):''}}" class="img-fluid" alt="">
        @elseif(empty($app->driverinfo->photo) && !empty($app->driverinfo->driver_is_owner) && $app->driverinfo->driver_is_owner== '1')
        <img src="{{!empty($app->applicant->applicantDetail->applicant_photo)?url($app->applicant->applicantDetail->applicant_photo):''}}" class="img-fluid" alt="">
        @endif
      </div>
    </div>
  </div>
</div>

<!-- End Driver Photo Modal -->


@endsection


@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/admins/js/review-blade.js')}}"></script>
<style>
  .img-magnifier-container {
    position:relative;
  }

  .img-magnifier-glass {
    position: absolute;
    border: 3px solid #000;
    border-radius: 50%;
    cursor: none;
    /*Set the size of the magnifier glass:*/
    width: 150px;
    height: 150px;
  }
</style>
<script>
  function magnify(imgID, zoom) {
    var img, glass, w, h, bw;
    img = document.getElementById(imgID);
    if (img != null) {
      /*create magnifier glass:*/
      glass = document.createElement("DIV");
      glass.setAttribute("class", "img-magnifier-glass");
      /*insert magnifier glass:*/
      img.parentElement.insertBefore(glass, img);
      /*set background properties for the magnifier glass:*/
      glass.style.backgroundImage = "url('" + img.src + "')";
      glass.style.backgroundRepeat = "no-repeat";
      glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
      bw = 3;
      w = glass.offsetWidth / 2;
      h = glass.offsetHeight / 2;
      /*execute a function when someone moves the magnifier glass over the image:*/
      glass.addEventListener("mousemove", moveMagnifier);
      img.addEventListener("mousemove", moveMagnifier);
      /*and also for touch screens:*/
      glass.addEventListener("touchmove", moveMagnifier);
      img.addEventListener("touchmove", moveMagnifier);

      function moveMagnifier(e) {
        var pos, x, y;
        /*prevent any other actions that may occur when moving over the image*/
        e.preventDefault();
        /*get the cursor's x and y positions:*/
        pos = getCursorPos(e);
        x = pos.x;
        y = pos.y;
        /*prevent the magnifier glass from being positioned outside the image:*/
        if (x > img.width - (w / zoom)) {
          x = img.width - (w / zoom);
        }
        if (x < w / zoom) {
          x = w / zoom;
        }
        if (y > img.height - (h / zoom)) {
          y = img.height - (h / zoom);
        }
        if (y < h / zoom) {
          y = h / zoom;
        }
        /*set the position of the magnifier glass:*/
        glass.style.left = (x - w) + "px";
        glass.style.top = (y - h) + "px";
        /*display what the magnifier glass "sees":*/
        glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
      }

      function getCursorPos(e) {
        var a, x = 0, y = 0;
        e = e || window.event;
        /*get the x and y positions of the image:*/
        a = img.getBoundingClientRect();
        /*calculate the cursor's x and y coordinates, relative to the image:*/
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /*consider any page scrolling:*/
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return {x: x, y: y};
      }
    }
  }

</script>
<script>
  $(document).ready(function(){
    // magnify('docImg1',3);
    // magnify('docImg2',3);
    // magnify('docImg3',3);
    // magnify('docImg4',3);
    // magnify('docImg5',3);
    // magnify('docImg6',3);
    // magnify('docImg7',3);
    // magnify('docImg8',3);
    // magnify('docImg9',3);
    // magnify('docImg10',3);
    // magnify('docImg11',3);
    // magnify('docImg12',3);
    // magnify('docImg13',3);
    // magnify('docImg14',3);
    // magnify('docImg16',3);
    // magnify('docImg17',3);
  });

</script>

@endsection
