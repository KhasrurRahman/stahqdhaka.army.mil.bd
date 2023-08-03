@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <style>

 h3.pptitle {
    font-size: 24px;
    display: inline-block;
}
 </style>
@endsection
@section('content')
<div class="content-area" style="padding-top: 15px;">
    <div class="container-fluid  pl-0 pr-0" >
        <div class="box">
            <div class="box-body">
                <h3 class="pptitle">Forwarded Applications To PS</h3>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">

                <div class="invoice_date_filter" style="float: right; margin-left:auto; ">
                    <form action="{{ url('application/forwarded-list') }}" method="get">
                        {{-- {{csrf_field()}}  --}}

                        <table>
                            <tr>
                                <td>
                                    <input type="text" name="applicant_name" value="{{ $applicant_name }}" class="form-control" placeholder="Name">
                                </td>
                                <td>
                                    <input type="text" name="ba" value="{{ $ba }}" class="form-control" placeholder="BA">
                                </td>
                                <td>
                                    <input type="text" name="rank" value="{{ $rank }}" class="form-control" placeholder="Rank">
                                </td>
                                <td>
                                    <input type="text" name="reg_no" value="{{ $reg_no }}" class="form-control" placeholder="Reg. No.">
                                </td>
                                <td>
                                    <input type="text" name="phone" value="{{ $phone }}" class="form-control" placeholder="Phone">
                                </td>
                                <td>
                                    <input type="text" name="date" value="{{ $date }}" class="form-control" placeholder="Date">
                                </td>
                                <td>
                                    <input type="text" name="Vehicle_Type" value="{{ $Vehicle_Type }}" class="form-control" placeholder="Vehicle Type">
                                </td>
                                <td>
                                    <input type="text" name="present_address" value="{{ $present_address }}" class="form-control" placeholder="Address">
                                </td>
                            </tr>
                        </table>
                        <br>
                      <label style="font-weight:bold;">From Date: </label> 
                      <input placeholder="dd-mm-yy" class="from_date" autocomplete="off" type="text" style="border: none; padding: 2px 5px;" name="forwarded_from_date" value="{{isset($forwarded_from_date) ? $forwarded_from_date: ''}}"> &nbsp;&nbsp;
                      <label style="font-weight:bold;">To Date: </label> <input placeholder="dd-mm-yy" class="to_date" autocomplete="off" type="text" style="border: none; padding: 2px 5px;" name="forwarded_to_date" value="{{isset($forwarded_to_date) ? $forwarded_to_date: ''}}">
                      <button type="submit" style="border: none; padding: 2px 5px; font-size: 14px;" class="btn btn-info">Show forwarded to MP DTE List</button>
                        </form>
                    </div> 
            </div>
            <div class="panel-body" style="padding:10px 0;">
                <div id="example-wrapper">
                    <table id="table" class="table table-bordered dt-responsive" style="text-align: center;">
                        <thead>
                            <tr>
                                {{-- <th scope="col">#</th>/ --}}
                                <th scope="col">Name, NID</th>
                                <th scope="col">BA</th>
                                <th scope="col">Rank</th>
                                <th scope="col">Reg. No.</th>
                                <th scope="col">Phone No.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Vehicle Type</th>
                                <th scope="col">Present Address</th>
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
                aLengthMenu: [
                    [10,25, 50, 100, 200, -1],
                    [10,25, 50, 100, 200, "All"]
                ],
                iDisplayLength: 10,
                ajax: {
                    url: '{{ route('forwarded_apps.datatable') }}',
                    data: function (d) {
                        d.forwarded_from_date = '{{ $forwarded_from_date }}';
                        d.forwarded_to_date = '{{ $forwarded_to_date }}';

                        d.applicant_name = '{{ $applicant_name }}';
                        d.ba = '{{ $ba }}';
                        d.rank = '{{ $rank }}';
                        d.reg_no = '{{ $reg_no }}';
                        d.phone = '{{ $phone }}';
                        d.date = '{{ $date }}';
                        d.Vehicle_Type = '{{ $Vehicle_Type }}';
                        d.present_address = '{{ $present_address }}';
                    }
                },
                columns: [
                    {data: 'applicant_name', name: 'applicant.name'},
                    {data: 'BA_no', name: 'BA_no'},
                    {data: 'Rank_id', name: 'Rank_id'},
                    {data: 'Reg_number', name: 'Reg_number'},
                    {data: 'phone_number', name: 'applicant.phone'},
                    {data: 'app_date', name: 'app_date'},
                    {data: 'vehicleType', name: 'vehicleType'},
                    {data: 'address', name: 'address'},
                ],
                order:[[5,"desc"]]
            });

        });

    </script>
@endsection
