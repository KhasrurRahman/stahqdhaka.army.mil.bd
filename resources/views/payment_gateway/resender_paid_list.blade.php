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
                    <form action="{{url('/resender_paid_massage/list')}}" method="GET">
                        {{csrf_field()}}
                        <table class="col-12">
                            <tr>
                                <td>
                                    <input type="text" name="applicant_name"  class="form-control" placeholder="Name" value="">
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
                                    <input type="text" name="ba" value="" class="form-control" placeholder="BA">
                                </td>
                                <td>
                                    <input type="text" name="rank" value="" class="form-control" placeholder="Rank">
                                </td>
                                <td>
                                    <input type="text" name="reg_no" value="" class="form-control" placeholder="Reg. No.">
                                </td>
                                <td>
                                    <input type="text" name="phone" value="" class="form-control" placeholder="Phone">
                                </td>
                                <td>
                                    <input type="text" name="vehicle_type" value="" class="form-control" placeholder="Vehicle Type">
                                </td>
                                <td>
                                    <input type="text" name="present_address" value="" class="form-control" placeholder="Address">
                                </td>
                                
                            </tr>
                        </table>
                        <br>
                        <label style="font-weight:bold;">Sticker Type: </label>
                        <select name="sticker_category" id="sticker_category" class="form-control-sm" >
                            
                            
                            
                           
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
    <script type="text/javascript" src="{{asset('/assets/admins/js/approved-sticker-list.blade.js')}}"></script>
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

// $(function() {
//     $('#table').DataTable({
        
//         processing: true,
//         serverSide: true,
//         aLengthMenu: [
//             [10,25, 50, 100, 200, -1],
//             [10,25, 50, 100, 200, "All"]
//         ],
//         iDisplayLength: 10,
//         ajax: {
//             url: '{{ route('approved_payment_report.datatable')}}',
//             // success: function(res) {
//             //     console.log(res);
//             //     alert(res);
//             // },
//             data: function (d) {
//                 
//             }
//         },
//         columns: [
//             
           
            
           
//         ],
//         order:[[0,"desc"]]
//     });

// });

</script>
    
@endsection