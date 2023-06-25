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
                <h3 style="float: left;" class="pptitle">Invoice Report</h3>

                   <div class="invoice_date_filter" style="float: right;margin-left:auto;  ">
                    <form action="{{ url('search/invoice/report') }}" method="post">
                        {{csrf_field()}}
                        <label> Type: </label> 
                         <select name="vehicle_type" id="vehicle_type" class="form-control-sm mandatory" >

                              <option selected="" value="{{!empty($vehicle_type)?$vehicle_type->id:''}}">{{!empty($vehicle_type)?$vehicle_type->name:'Select One'}}</option>

                                 <?php $vehicleTypes=App\VehicleType::all(); ?>
                                    @if(isset($vehicleTypes))

                                        @foreach($vehicleTypes as $vehicleType)
                                    <option value="{{$vehicleType->id}}">{{$vehicleType->name}}</option>
                                        @endforeach
                                    @endif
                  </select>
                    <label> From: </label> <input style="border: none; padding: 2px 5px;" class="form-control-sm from_date" autocomplete="off" placeholder="dd-mm-yy" type="text" name="start_inv_date" value="{{isset($date_from) ? $date_from : ''}}">
                      <label>To:</label> <input class="form-control-sm from_date" type="text" autocomplete="off" placeholder="dd-mm-yy" style="border: none; padding: 2px 5px;" name="end_inv_date" value="{{isset($date_to) ? $date_to : ''}}">
                      <button type="submit" style="border: none; padding: 2px 5px; font-size: 14px;" class="btn-info">Show Invoice</button> 
                        </form>
                    </div> 

             </div>
             <div class="panel-body" style="padding:10px 0;" >
                <div id="example-wrapper">
                    <!-- table-1 -->
                    <table id="example" class="table table-bordered dt-responsive">
                        <thead>
                        <tr>
                            <th scope="col" style="text-align:center">#</th>
                            <th scope="col" style="text-align:center">Vehicle Type</th>
                            <th scope="col" style="text-align:center">No. of Issuance</th>
                            <th scope="col" style="text-align:center">Total Amount Collected</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $countVehicle=0; $countTotal=0; ?>
                        @if(isset($invoices) &&  $invoices !='')
                         @foreach($invoices as $key => $invoice)
                       <tr  style="text-align:right">
                           <th scope="row"  style="text-align:center">{{$loop->iteration}}</th>
                            <td  style="text-align:center"> {{$invoice->vehicleType->name}}</td>

                            <td class="no-of-issuance"  style="text-align:center">
                                
                                    {{count(App\Invoice::where('vehicle_type_id', $invoice->vehicle_type_id)->get())}}
                                    <?php $countVehicle+=count(App\Invoice::where('vehicle_type_id', $invoice->vehicle_type_id)->get()); ?>
                                
                            </td>
                            <td class="total-ammount"> 
                                     {{sprintf('%0.2f',App\Invoice::where('vehicle_type_id', $invoice->vehicle_type_id)->sum('net_amount'))}}
                                    <?php $countTotal+=sprintf('%0.2f',App\Invoice::where('vehicle_type_id', $invoice->vehicle_type_id)->sum('net_amount')) ?>
                            </td>
                        
                           
                       </tr>
                           @endforeach
                        <tr style="text-align:right">
                            <th colspan="" style="text-align: center;"> Total</th>
                            <th  style="text-align: center;"></th>
                            <th style="text-align: center;">{{$countVehicle}}</th>
                            <th>{{sprintf('%0.2f', $countTotal)}}</th>
                        </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
                
                <hr>

                <div class="table2-wrap" style="padding:0 15px">
                    <!-- table-2 -->
                    <table class="table table-bordered dt-responsive mt-4">
                        <thead>
                        <tr>
                            <th scope="col" style="text-align:center">Total</th>
                            <th scope="col" style="text-align:center">Pass Issued</th>
                            <th scope="col" style="text-align:center">Revenue</th>
                            <th scope="col" style="text-align:center">Sta Fund</th>
                            <th scope="col" style="text-align:center">Vat</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr style="text-align:center">
                                <th></th>
                                <th>{{$countVehicle > 0 ? $countVehicle : '0.00'}}</th>
                                <th>{{$countTotal > 0 ? sprintf('%0.2f',$countTotal) : '0.00'}}</th>
                                <th>{{$countTotal > 0 ? sprintf('%0.2f',$countTotal/1.15) : '0.00'}}</th>
                                <th>{{$countTotal > 0 ? sprintf('%0.2f',$countTotal - $countTotal/1.15) : '0.00'}}</th>
                            </tr>
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