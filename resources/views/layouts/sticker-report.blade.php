@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
    <div class="content-area kjkjk" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
            <div class="panel-heading" style="overflow: hidden;">
                <h3 style="float: left;" class="pptitle">Sticker Report</h3>

                <div class="invoice_date_filter" style="float: right; margin-left:auto;  ">
                    <form action="{{ url('search/sticker/report') }}" method="post">
                        {{csrf_field()}}
                    <label> From: </label> <input style="border: none; padding: 2px 5px;" class="form-control-sm from_date" placeholder="dd-mm-yy" type="text" name="start_sticker_date" value="{{isset($date_from) ? $date_from : ''}}">
                      <label>To:</label> <input class="form-control-sm to_date" type="text" placeholder="dd-mm-yy" style="border: none; padding: 2px 5px;" name="end_sticker_date" value="{{isset($date_to) ? $date_to : ''}}">
                      <button type="submit" style="border: none; padding: 2px 5px; font-size: 14px;" class="btn-info">Show Report</button> 
                    </form>
                </div>  

             </div>
             <div class="panel-body" style="padding:10px 0;" >
            	<div id="example-wrapper">
                    
            	<table id="example" class="table table-bordered dt-responsive">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sticker Type</th>
                        <th scope="col">Army</th>
                        <th scope="col">Non-Army</th>
                        <th scope="col">Army(PS Approved)</th>
                        <th scope="col">Non-Army(PS Approved)</th>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php $counter1=0;$counter2=0;$counter3=0;$counter4=0; $count_ser=0; ?>
                    @if(isset($sticker_reports) &&  $sticker_reports !='')
                     @foreach($sticker_reports as $key => $sticker_report)
                   <tr>
                       <th scope="row">{{$loop->iteration}}</th>
                        <td> {{$sticker_report->sticker_value}}</td>

                        <td class="no-of-issuance">
                        	
                        	{{count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'def')->get())>0?count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'def')->get()):''}}
                        	<?php
                        		$counter1+=count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'def')->get());
                        	 ?>
                        		
                        	
                        </td>
                        <td class="total-ammount"> 
                        	{{count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'non-def')->get())>0?count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'non-def')->get()):''}}
							<?php 
								$counter2+=count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'non-def')->get());
							?>
                        </td>
                        <td>
                        	{{count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'def')->where('ps_approved', '1')->get())>0?count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'def')->where('ps_approved', '1')->get()):''}}
                        	<?php 
								$counter3+=count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'def')->where('ps_approved', '1')->get());
							?>
                        </td>
                        <td>
                        	{{count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'non-def')->where('ps_approved', '1')->get())>0?count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'non-def')->where('ps_approved', '1')->get()):''}}
                        	<?php 
								$counter4+=count(App\Application::where('id', $sticker_report->application_id)->where('app_status', 'issued')->where('type', 'non-def')->where('ps_approved', '1')->get());
							?>
                        </td>
                    
                       
                   </tr>
                   <?php $count_ser++?>
                       @endforeach
                    <tr>
                    	<th colspan="" style="text-align: right;"> Total</th>
                    	<th>{{$count_ser}}</th>
                    	<th>{{$counter1}}</th>
                    	<th>{{$counter2}}</th>
                    	<th>{{$counter3}}</th>
                    	<th>{{$counter4}}</th>
                    </tr>
                    @endif

                    </tbody>
                </table>
            	 </div>
            
            </div>
        </div>

       </div>
        

    </div>
@endsection

@section('admin-script')
    <script src="{{ asset('assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            //Date picker
            $('.from_date,.to_date').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });
        });

    </script>
@endsection