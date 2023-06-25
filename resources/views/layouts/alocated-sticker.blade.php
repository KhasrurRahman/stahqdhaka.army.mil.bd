@extends('layouts.customer-master')
@section('content')
        <div class="col-md-10" id="content_term_condition" style="margin-top:10px; ">  	
        <div class="content-area" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="pptitle">Your Vehicle Sticker</h3>
            </div>
            <div class="panel-body" style="padding:15px;">
             <div id="example-wrapper">
                <table id="example" class="table table-bordered dt-responsive" style="text-align: center;">
                    <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Name</th>
                        <th scope="col">Reg. No.</th>
                        <th scope="col">Phone No.</th>
                        <th scope="col">Vehicle Type</th>
                        <th scope="col">Sticker Number</th>
                        <th scope="col">Sticker Category</th>
                        <th scope="col">Received Date</th>
                        <th scope="col">Expired Date</th>
                        <th scope="col">Renew Sticker</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset(auth()->guard('applicant')->user()->vehicleStickers))
                    <?php $sl=1; ?>
                     @foreach(auth()->guard('applicant')->user()->vehicleStickers as $key => $vehicleSticker)
                   <tr>
                       <th scope="row">{{$sl++}}</th>
                        <td>
                        <a> {{$vehicleSticker->application->applicant->name}} </a></td>
                        <td>{{!empty($vehicleSticker->reg_number) ? $vehicleSticker->reg_number : ''}}</td>
                        <td>{{!empty($vehicleSticker->application->applicant->phone)?$vehicleSticker->application->applicant->phone:''}} </td>
                        <td>{{!empty($vehicleSticker->application->vehicleinfo->vehicleType->name)?$vehicleSticker->application->vehicleinfo->vehicleType->name:''}}</td>
                        <td>{{!empty($vehicleSticker->sticker_number)?$vehicleSticker->sticker_number:''}}</td>
                        <td>{{!empty($vehicleSticker->sticker_value)?$vehicleSticker->sticker_value:''}}</td>
                        <td>{{!empty($vehicleSticker->application->applicationNotify->sticker_delivery_date)?$vehicleSticker->application->applicationNotify->sticker_delivery_date:''}}</td>
                        <td>{{!empty($vehicleSticker->exp_date)?$vehicleSticker->exp_date:''}}</td>
                         <td>
                            <?php
                                $now = Carbon\Carbon::now()->addDays(16)->toDateString();
                                $old_app=App\Application::find($vehicleSticker->application_id);
                            ?>
                            @if($now >= $vehicleSticker->exp_date && $old_app->renew_app_id == null)
                            <a  class="btn btn-info" href="{{url('/renew/sticker')}}/{{$vehicleSticker->id}}">Renew</a>
                            @elseif($old_app->renew_app_id != '')
                            <span style="border: 1px solid #000;padding: 3px 10px; border-radius: 5px">Already Applied </span>
                            @endif 
                        </td>
                   </tr>
                       @endforeach
                    @else
                    <tr>
                    	<td colspan="10" style="background-color: #e286142b;">
                    		No Sticker Available
                    	</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            </div>
        </div>

       </div>
        

    </div>


				</div>
	
@endsection