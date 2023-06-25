@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('retakeApp', $def) }}" method="GET">
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
                                <td>
                                    <button class="btn btn-info"> Search </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="pptitle">Retake Applications</h3>
                </div>
                <div class="panel-body" style="padding:10px 0;">
                <div id="example-wrapper">
                    <table id="table" class="table table-bordered dt-responsive" style="text-align: center;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
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
                    url: '{{ route('all_retake.datatable') }}',
                    data: function (d) {
                        d.def = '{{ $def }}';
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
                    // {data: 'id', name: 'id'},
                    {data: 'DT_RowIndex', name: 'id', searchable: false},
                    {data: 'applicant_name', name: 'applicant.name'},
                    {data: 'BA_no', name: 'applicant.applicantDetail.applicant_BA_no'},
                    {data: 'Rank_id', name: 'applicant.applicantDetail.rank.name'},
                    {data: 'Reg_number', name: 'vehicleinfo.reg_number'},
                    {data: 'phone_number', name: 'applicant.phone'},
                    {data: 'app_date', name: 'app_date'},
                    {data: 'vehicleType', name: 'vehicleinfo.vehicleType.name'},
                    {data: 'address', name: 'applicant.applicantDetail.address'},
                ],
                order:[[0,"desc"]]
            });

        });

    </script>
@endsection