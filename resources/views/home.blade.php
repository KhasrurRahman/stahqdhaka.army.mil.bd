@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('style')
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('assets/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
  <div class="content-area">
    <!-- search-form starts -->
    <div class="container-fluid" id="search-form">
      <form action="{{url('/home')}}" method="GET">
       {{csrf_field()}}
        <div class="row">
          <div class="col-md-6 field-wrap">
            @if(isset($applicant_name) && $applicant_name!='')
              <label class="checkbox-container">
                <input type="checkbox"  id="name_check" class="check_box_select" data-input="{{$applicant_name}}" name="name_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="name">Applicant Name</label>
              <input type="text" name="name"   id="name_inp" class="form-control" value="{{$applicant_name}}">
            @else
              <label class="checkbox-container">
                <input type="checkbox"  id="name_check" class="check_box_select" name="name_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Applicant Name</label>
              <input type="text" name="name" readonly="" placeholder="" id="name_inp" class="form-control">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($applicant_BA) && $applicant_BA != '')
              <label class="checkbox-container">
                <input type="checkbox"  id="BA_check" class="check_box_select" data-input="{{$applicant_BA}}" name="BA_check" value="1"
                       checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Applicant BA</label>
              <input type="text" name="BA"   id="BA_inp" class="form-control" value="{{$applicant_BA}}">
            @else
              <label class="checkbox-container">
                <input type="checkbox"  id="BA_check" class="check_box_select" name="BA_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Applicant BA</label>
              <input type="text" name="BA" readonly="" placeholder="" id="BA_inp" class="form-control">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            <?php $ranks=DB::table('ranks')->get(); ?>
            @if(isset($applicant_Rank) && $applicant_Rank!='')
              <label class="checkbox-container">
                <input type="checkbox"  id="rank_check" class="check_box_select" data-input="{{ $applicant_Rank }}" name="rank_check" value=
                "1" checked>
                <span class="checkmark"></span>
              </label>
              <label for=""> Rank</label>
              <select type="text" name="rank"  id="rank_inp" class="form-control-sm in-form" value="{{$applicant_Rank}}">
                {{-- <option selected value="{{$applicant_Rank->id}}"> {{$applicant_Rank->name}}</option> --}}
                @if(isset($ranks) && count($ranks)>0)
                  @foreach($ranks as $rank)
                    <option @if ($applicant_Rank == $rank->id) selected @endif value="{{$rank->id}}">{{$rank->name}}</option>
                  @endforeach
                @endif
              </select>
            @else
              <label class="checkbox-container">
                <input type="checkbox"  id="rank_check" class="check_box_select" name="rank_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Rank</label>
              <select type="text" name="rank"  placeholder="" id="rank_inp" class="form-control-sm in-form" disabled="">
                <option selected value="" disabled="">--Select Rank--</option>
                @if(isset($ranks) && count($ranks)>0)
                  @foreach($ranks as $rank)
                    <option value="{{$rank->id}}">{{$rank->name}}</option>
                  @endforeach
                @endif
              </select>
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($glass_type)  && $glass_type!='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-glass="{{$glass_type}}" data-select="{{$glass_type}}" name="
            glass_type_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Glass Type</label>
              <select name="glass_type" id="glass_type" class="form-control-sm glass_type_inp in-form">
                <option selected value="{{$glass_type}}"> {{$glass_type}}</option>
                <option  value="normal-transparent">Transparent Normal Glass </option>
                <option  value="transparent">Transparent </option>
                <option value="semi-black"> Semi-Black </option>
                <option value="black">Black</option>
              </select>
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="glass_type_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Glass Type</label>
              <select name="glass_type" id="glass_type" class="form-control-sm glass_type_inp in-form" disabled="">
                <option selected value="" readonly> Select One </option>
                <option  value="normal-transparent">Transparent Normal Glass </option>
                <option  value="transparent">Transparent </option>
                <option value="semi-black"> Semi-Black </option>
                <option value="black">Black</option>
              </select>
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($applicant_phone) && $applicant_phone!='')
              <label class="checkbox-container">
                <input type="checkbox" class="phone_check check_box_select" data-input="{{$applicant_phone}}" name="phone_check" value="1"
                       checked="">
                <span class="checkmark"></span>
              </label>
              <label for="">Phone Number</label>
              <input type="text" name="phone" placeholder="" class="form-control phone_inp" value="{{ $applicant_phone }}">
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="phone_check check_box_select" name="phone_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Phone Number</label>
              <input type="text" name="phone" placeholder="" class="form-control phone_inp" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($reg_no) && $reg_no!='')
              <label class="checkbox-container">
                <input type="checkbox" class="reg_check check_box_select" data-input="{{$reg_no}}" name="reg_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Vehicle Reg No</label>
              <input type="text" name="reg_no" placeholder="" value="{{$reg_no}}" class="form-control reg_inp">
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="reg_check check_box_select" name="reg_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Vehicle Reg No</label>
              <input type="text" name="reg_no" placeholder="" class="form-control reg_inp" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($applicant_nid_number) && $applicant_nid_number!='')
              <label class="checkbox-container">
                <input type="checkbox" name="nid_check" class="check_box_select" data-input="{{$applicant_nid_number}}" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">NID</label>
              <input type="text" name="nid_number" placeholder="" class="form-control nid_inp" value="{{$applicant_nid_number}}">
            @else
              <label class="checkbox-container">
                <input type="checkbox" name="nid_check" class="check_box_select" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Nat ID</label>
              <input type="text" name="nid_number" placeholder="" class="form-control nid_inp" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($sticker_no) && $sticker_no!='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-input="{{$sticker_no}}" name="sticker_no_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Sticker No.</label>
              <input type="text" name="sticker_no" placeholder="" class="form-control sticker_no_inp" value="{{$sticker_no}}">
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="sticker_no_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Sticker No.</label>
              <input type="text" name="sticker_no" placeholder="" class="form-control sticker_no_inp" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($vehicle_type) && $vehicle_type!='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-vehicle="{{$vehicle_type}}" data-select="
            {{$vehicle_type}}" name="vehicle_type_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Vehicle Type</label>
              <select name="vehicle_type" id="" class="form-control-sm vehicle_type_inp in-form">
                {{-- <option selected value="{{$vehicle_type->id}}"> {{$vehicle_type->name}}</option> --}}
                @if(isset($vehicleTypes) && $vehicleTypes!='')
                  @foreach($vehicleTypes as $n_vehicleType)
                    <option @if ($n_vehicleType->id == $vehicle_type) selected @endif value="{{$n_vehicleType->id}}"> {{$n_vehicleType->name}} </option>
                  @endforeach
                @endif
              </select>
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="vehicle_type_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Vehicle Type</label>
              <select name="vehicle_type" id="" class="form-control-sm vehicle_type_inp in-form" disabled="">
                <option readonly> Select One </option>
                @if(isset($vehicleTypes) && $vehicleTypes!='')
                  @foreach($vehicleTypes as $vehicleType)
                    <option value="{{$vehicleType->id}}"> {{$vehicleType->name}} </option>
                  @endforeach
                @endif
              </select>
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($sticker_type) && $sticker_type!='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-sticker="{{$sticker_type}}" data-select="
            {{$sticker_type}}" name="sticker_type_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Sticker Type</label>
              <select name="sticker_type" id="sticker_type" class="form-control-sm sticker_type_inp in-form">
                {{-- <option selected value="{{$sticker_type->value}}"> {{$sticker_type->name}}</option> --}}

                <option readonly> Select One </option>
                @if(isset($stickerTypes) && $stickerTypes!='')
                  @foreach($stickerTypes as $stickerType)
                    <option @if ($sticker_type == $stickerType->value) selected @endif value="{{$stickerType->value}}"> {{$stickerType->name}} </option>
                  @endforeach
                @endif
              </select>
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="sticker_type_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Sticker Type</label>
              <select name="sticker_type" id="sticker_type" class="form-control-sm sticker_type_inp in-form" disabled="">
                <option readonly> Select One </option>
                @if(isset($stickerTypes) && $stickerTypes!='')
                  @foreach($stickerTypes as $stickerType)
                    <option value="{{$stickerType->value}}"> {{$stickerType->name}} </option>
                  @endforeach
                @endif
              </select>
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($house) && $house!='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-input="{{$house}}" name="house_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">House</label>
              <input type="text" name="house" placeholder="" class="form-control house_inp" value="{{$house}}">
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="house_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">House</label>
              <input type="text" name="house" placeholder="" class="form-control house_inp" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($road) && $road!='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-input="{{$road}}" name="road_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Road</label>
              <input type="text" name="road" placeholder="" class="form-control road_inp" value="{{$road}}">
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="road_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Road</label>
              <input type="text" name="road" placeholder="" class="form-control road_inp" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($area) && $area!='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-input="{{$area}}" name="area_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">Area</label>
              <input type="text" name="area" placeholder="" class="form-control area_inp" value="{{$area}}">
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="area_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">Area</label>
              <input type="text" name="area" placeholder="" class="form-control area_inp" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($date_from) && $date_from !='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-input="{{$date_from}}" checked name="from_date_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">From Date</label>
              <input type="text" name="from_date"  value="{{$date_from}}" placeholder="dd-mm-yy" class="form-control from_date" id="" autocomplete="off">
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select"  name="from_date_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">From Date</label>
              <input type="text" name="from_date" value="" placeholder="dd-mm-yy" class="form-control from_date" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
            @if(isset($date_to) && $date_to !='')
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" data-input="{{$date_to}}" name="end_date_check" value="1" checked>
                <span class="checkmark"></span>
              </label>
              <label for="">To Date</label>
              <input type="text"  name="end_date" value="{{$date_to}}" placeholder="dd-mm-yy" autocomplete="off" class="form-control from_date" >
            @else
              <label class="checkbox-container">
                <input type="checkbox" class="check_box_select" name="end_date_check" value="1">
                <span class="checkmark"></span>
              </label>
              <label for="">To Date</label>
              <input type="text" name="end_date" placeholder="dd-mm-yy" class="form-control from_date" readonly="">
            @endif
          </div>
          <div class="col-md-6 field-wrap">
                @if(isset($year) && $year !='')
                <label class="checkbox-container">
                    <input type="checkbox" class="check_box_select" data-input="{{$year}}" name="year_check" value="1" checked>
                    <span class="checkmark"></span>
                </label>
                <label for="">Year</label>
                <input type="number" name="year" value="{{$year}}" placeholder="" class="form-control year_inp" >
                @else
                <label class="checkbox-container">
                    <input type="checkbox" class="check_box_select" name="year_check" value="1">
                    <span class="checkmark"></span>
                </label>
                <label for="">Year</label>
                <input type="number" name="year" value="" placeholder="" class="form-control year_inp" readonly="">
                @endif
          </div>
          <div class="col-md-2 offset-md-5">
            <button type="submit" class="btn btn-primary btn-block mb-4" style="background-color:#0098dd;" id="search-btn">Search</button>
          </div>
        </div>
      </form>
    </div><!-- search-form  -->

    <!-- Recent Applications -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="pptitle">Recent Applications</h3>
        <a style="margin-left: 10px;" href="{{url('/home')}}" class="btn btn-info">Default</a>
        <a style="margin-left: 10px;" href="{{url('/home')}}" class="btn btn-warning">Load All Apps</a>


        <button id="printButton" class="btn buttons-print btn-info apps-print-btn" style="margin-left: auto" onclick="Print_home_list('datatable')"><span><i class="fa fa-print"></i> Print</span></button>
      </div>

      <div class="panel-body" style="padding:10px 0;">
        <div id="example-wrapper"  style="overflow-x:auto;">
          <table id="table" class="table table-bordered responsive" border="1" style="text-align: center;">
            <thead style="background: #000;">
                <tr>
                {{-- <th scope="col">#</th> --}}
                <th scope="col">Name, NID</th>
                <th scope="col">BA</th>
                <th scope="col">Rank</th>
                <th scope="col">Phone No.</th>
                <th scope="col">Pre. Address</th>
                <th scope="col">Apply Date</th>
                <th scope="col">Vehicle Type</th>
                <th scope="col">Glass Type</th>
                <th scope="col">Cust. Type</th>
                <th scope="col">Stkr. Type</th>
                <th scope="col">Stkr. No</th>
                <th scope="col">Reg. No.</th>
                <th scope="col" class="ata">Status</th>
                <th scope="col" class="ata">Payment Status</th>
                </tr>
            </thead>
          </table>
        </div>
      </div>
    </div><!-- Recent Applications -->
  </div>

@endsection

@section('admin-script')
  <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>

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
                searching: false,
                ajax: {
                    url: '{{ route('all_apps.datatable') }}',
                    data: function (d) {
                        d.applicant_name = '{{ $applicant_name }}';
                        d.applicant_BA = '{{ $applicant_BA }}';
                        d.applicant_Rank = '{{ $applicant_Rank }}';
                        d.glass_type = '{{ $glass_type }}';
                        d.applicant_phone = '{{ $applicant_phone }}';
                        d.reg_no = '{{ $reg_no }}';
                        d.applicant_nid_number = '{{ $applicant_nid_number }}';
                        d.sticker_no = '{{ $sticker_no }}';
                        d.sticker_type = '{{ $sticker_type }}';
                        d.vehicle_type = '{{ $vehicle_type }}';
                        d.house = '{{ $house }}';
                        d.road = '{{ $road }}';
                        d.area = '{{ $area }}';
                        d.date_from = '{{ $date_from }}';
                        d.date_to = '{{ $date_to }}';
                        d.year = '{{ $year }}';
                    }
                },
                columns: [
                    {data: 'applicant_name', name: 'applicant.name'},
                    {data: 'BA_no', name: 'BA_no'},
                    {data: 'Rank_id', name: 'Rank_id'},
                    {data: 'phone_number', name: 'applicant.phone'},
                    {data: 'address', name: 'address'},
                    {data: 'app_date', name: 'app_date'},
                    {data: 'vehicleType', name: 'vehicleType'},
                    {data: 'glass_type', name: 'glass_type'},
                    {data: 'type', name: 'type'},
                    {data: 'sticker_category', name: 'sticker_category'},
                    {data: 'sticker_number', name: 'sticker_number'},
                    {data: 'Reg_number', name: 'Reg_number'},
                    {data: 'app_status', name: 'app_status'},
                    {data: 'payment_status', name: 'payment_status'},
                ],
                order:[[5,"desc"]]
            });

        });
  </script>
  <script type="text/javascript" src="{{asset('/assets/admins/js/print-for-home.js')}}"></script>
@endsection

