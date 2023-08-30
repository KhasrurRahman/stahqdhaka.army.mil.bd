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
        <div class="container-fluid pl-0 pr-0">
            <div class="panel panel-default">
            <div class="row col-md-12" style="text-align: center">
                <b>All Approved Sticker List</b> <br>
            </div>
            <div class="panel-heading">
                <div class="invoice_date_filter" style="">
                    <form action="{{url('/payment_report/list')}}" method="GET">
                        {{csrf_field()}}
                        <table class="col-12">
                            <tr>
                                <td>
                                    <input type="text"  name="applicant_name"  class="form-control" placeholder="Name" value="{{ $applicant_name }}">
                                </td>
                                <td>
                                    <select name="applicant_type" id="" class="form-control">
                                        <option value=""> Select Type</option>
                                        <option value="def"> Defence</option>
                                        <option value="non-def"> Non Defence</option>
                                    </select>
                                    <!-- <input type="text" name="applicant_type"  class="form-control" placeholder="Applicant Type"> -->
                                </td>                             
                                <td>
                                    <input type="text" name="ba" value="{{$ba}}" class="form-control" placeholder="BA">
                                </td>
                                <td>
                                    <input type="text" name="rank" value="{{$rank}}" class="form-control" placeholder="Rank">
                                </td>
                                <td>
                                    <input type="text" name="reg_no" value="{{$reg_no}}" class="form-control" placeholder="Reg. No.">
                                </td>
                                <td>
                                    <input type="text" name="phone" value="{{$phone}}" class="form-control" placeholder="Phone">
                                </td>
                                <td>
                                    <input type="text" name="vehicle_type" value="{{$vehicle_type}}" class="form-control" placeholder="Vehicle Type">
                                </td>
                                <td>
                                    <input type="text" name="present_address" value="{{$present_address}}" class="form-control" placeholder="Address">
                                </td>
                                
                            </tr>
                        </table>
                        <br>
                        <label style="font-weight:bold;">Sticker Type: </label>
                        <select name="sticker_category" id="sticker_category" class="form-control-sm" >
                            
                            @if(!empty($sticker_categories))
                            <option value="">Select One</option>
                            @endif
                            @foreach($sticker_categories as $s)
                            <option value="{{$s->value}}">{{$s->name}}</option>
                            @endforeach
                            
                           
                        </select> &nbsp;&nbsp;
                        <label style="font-weight:bold;">Approval Count </label>
                        <select name="approval_count" id="approval_count" class="form-control-sm" >
                                                     
                            <option value="">Select One</option>                         
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>

                        </select> &nbsp;&nbsp;
                        <label style="font-weight:bold;">From Date: </label>
                        <input class="form-control-sm from_date" placeholder="dd-mm-yy" type="text" style="border: none; padding: 2px 5px;" name="inspec_from_date"  autocomplete="off">
                        &nbsp;&nbsp;
                        <label style="font-weight:bold;">To Date: </label>
                        <input class="form-control-sm to_date" placeholder="dd-mm-yy" type="text" style="border: none; padding: 2px 5px;" name="inspec_to_date"  autocomplete="off">
                         &nbsp;&nbsp;
                        <button type="submit" class="btn btn-info btn-sm">Submit</button>

                    </form>
                </div>
                 &nbsp;&nbsp; &nbsp;&nbsp;
                <button id="printButton" class="btn buttons-print btn-info btn-sm"><span><i class="fa fa-print"></i> Print</span></button>
            </div>
            <div class="panel-body" style="padding:10px 0;">
                <div id="example-wrapper-2" class="table-responsive">

                    <table id="table" class="table table-bordered dt-responsive" style="text-align: center; width:95%;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>            
                            <th scope="col">Type</th>
                            <th scope="col">BA</th>
                            <th scope="col">Rank</th>
                            <th scope="col">Reg no</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Vehicle Type</th>
                            <th scope="col">Glass Type</th>
                            <th scope="col">Sticker Type</th>                                                   
                            <th scope="col">Created_at</th>                          
                            <th scope="col">Amount</th>
                            <th scope="col">Address</th>
                            <th scope="col">Paid In</th>
                            
                        </tr>
                        </thead>  
                        
                        <tfoot>
                            <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                                <td ></td>
                                <td> </td>
                                <td> </td>
                                <td ></td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                        </tfoot>

                    </table>
                    
                </div>
                <!-- <div style="width: 100%; height:60px;background-color:#33880A; display: flex;
        justify-content: center;
        align-items: center; margin-top:10px; border-radius:3px;"> <h3 style="color: white; padding:0; margin:0;">Total Amount: </h3></div> -->
              
            </div>
        </div>

       </div>
        

    </div>
  

@endsection

@section('admin-script')
    <script type="text/javascript" src="{{asset('/assets/admins/js/approved-sticker-list.blade.js')}}"></script>
    <script src="{{ asset('assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{asset('/assets/admins/js/datatablesum.js')}}"></script>
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
  
    var dataTable=$('#table').DataTable({

        "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = this.api().ajax.json().sum_balance
                
                    $(api.column(11).footer()).html(
                        'Tk ' + total + ' total'
                    );
                },
        processing: true,
        serverSide: true,
        aLengthMenu: [
            [10,25, 50, 100, 200, -1],
            [10,25, 50, 100, 200, "All"]
        ],
        iDisplayLength: 10,
        ajax: {
            url: '{{ route('approved_payment_report.datatable')}}',
            data: function (d) {
                d.inspec_from_date = '{{ $inspec_from_date }}';
                d.inspec_to_date = '{{ $inspec_to_date }}';
                d.applicant_name = '{{ $applicant_name }}';
                d.applicant_type = '{{ $applicant_type }}';
                d.sticker_type = '{{ $sticker_type }}';
                d.ba = '{{ $ba }}';
                d.phone = '{{ $phone }}';
                d.vehicle_type = '{{ $vehicle_type }}';
                d.rank = '{{ $rank }}';
                d.present_address = '{{ $present_address }}';
                d.reg_no = '{{ $reg_no }}';
                d.approval_count = '{{ $approval_count }}';
            },
           
        },
        columns: [
            {data: 'DT_RowIndex', name: 'id', searchable: false},
            {data: 'name'},
            {data: 'type'},
            {data: 'applicant_BA_no'},           
            {data: 'rank_name'},
            {data: 'sticker_reg_number'},          
            {data: 'phone'},         
            {data: 'vehicle_name'},
            {data: 'glass_type'},
            {data: 'sticker_category'},
            {data: 'created_at'},
            {data: 'credit'},
            {data: 'address'},
            {data: 'approval_count'},
        ],
        order:[[0,"desc"]]
    });


});

</script>
    
@endsection