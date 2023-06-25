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
    <div class="container-fluid  pl-0 pr-0">
        <div class="panel panel-default">
            <div class="panel-heading" style="overflow: hidden;">
                <h3 style="float: left;" class="pptitle">Invoice List</h3>
                <div class="invoice_date_filter" style="float: right; margin-left:auto; ">
                    <form action="{{ url('invoice-list') }}" method="GET">
                        {{-- {{csrf_field()}} --}}
                        <table>
                            <tr>
                                <td>
                                    <input type="text" name="applicant_name" value="{{ $applicant_name }}" class="form-control" placeholder="Name">
                                </td>
                                <td>
                                    <input type="text" name="invoice_number" value="{{ $invoice_number }}" class="form-control" placeholder="invoice_number">
                                </td>
                                <td>
                                    <input type="text" name="reg_no" value="{{ $reg_no }}" class="form-control" placeholder="reg_no">
                                </td>
                                <td>
                                    <input type="text" name="date" value="{{ $date }}" class="form-control" placeholder="date">
                                </td>
                                <td>
                                    <input type="text" name="Vehicle_Type" value="{{ $Vehicle_Type }}" class="form-control" placeholder="Vehicle_Type">
                                </td>
                                <td>
                                    <input type="text" name="collector" value="{{ $collector }}" class="form-control" placeholder="collector">
                                </td>
                                <td>
                                    <input type="text" name="amount" value="{{ $amount }}" class="form-control" placeholder="amount">
                                </td>
                            </tr>
                        </table>
                        <br>
                        <label> From: </label> <input style="border: none; padding: 2px 5px;" class="from_date" type="text" placeholder="dd-mm-yy" autocomplete="off" name="start_inv_date" value="{{isset($date_from) ? $date_from : ''}}">
                        <label>To:</label> <input class="from_date" type="text" style="border: none; padding: 2px 5px;" placeholder="dd-mm-yy" autocomplete="off" name="end_inv_date" value="{{isset($date_to) ? $date_to : ''}}">
                        <button type="submit" style="border: none; padding: 2px 5px; font-size: 14px;" class="btn-info">Show Invoice</button> 
                    </form>
                </div> 
            </div>
            <div class="panel-body" style="padding:10px 0;" >
            	<div id="example-wrapper">

                 <table id="table" class="table table-bordered dt-responsive">
                    <thead>
                        <tr>
                            {{-- <th scope="col">#</th> --}}
                            <th scope="col">Invoice Number</th>
                            <th scope="col">Applicant Name</th>
                            <th scope="col">Vehicle Type</th>
                            <th scope="col">Vehicle Reg. No.</th>
                            <th scope="col">Sticker Type</th>
                            <th scope="col">Received By</th>
                            <th scope="col">Created Date</th>
                            <th scope="col">Total Ammount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
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

<script>
    $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('invoice.datatable') }}',
                    data: function (d) {
                        d.date_from = '{{ $date_from }}';
                        d.date_to = '{{ $date_to }}';

                        d.applicant_name = '{{ $applicant_name }}';
                        d.invoice_number = '{{ $invoice_number }}';
                        d.reg_no = '{{ $reg_no }}';
                        d.date = '{{ $date }}';
                        d.Vehicle_Type = '{{ $Vehicle_Type }}';
                        d.collector = '{{ $collector }}';
                        d.amount = '{{ $amount }}';
                    }
                },
                columns: [
                    {data: 'invoice_number', name: 'number'},
                    {data: 'application_applicant_name', name: 'application_applicant_name'},
                    {data: 'vehicleType_name', name: 'vehicleType_name'},
                    {data: 'application_vehicleinfo_reg_number', name: 'application_vehicleinfo_reg_number'},
                    {data: 'stickerCategory_value', name: 'stickerCategory_value'},
                    {data: 'collector', name: 'collector'},
                    {data: 'invoice_date', name: 'invoice_date'},
                    {data: 'net_amount', name: 'net_amount'},
                    {data: 'action', name: 'action'},
                ],
                // order:[[5,"desc"]]
            });

        });
</script>
@endsection