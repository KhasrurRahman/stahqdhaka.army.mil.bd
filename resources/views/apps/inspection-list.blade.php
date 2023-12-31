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
                    <form action="{{url('/all-approved/application')}}" method="GET">
                        {{csrf_field()}}
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
                        <label style="font-weight:bold;">Sticker Type: </label>
                        <select name="sticker_category" id="sticker_category" class="form-control-sm" >
                            <option selected value="{{!empty($stickerType)?$stickerType->value:''}}">{{!empty($stickerType)?$stickerType->value:'Select One'}}</option>
                            @if(!empty($stickerType))
                            <option value="">Select One</option>
                            @endif
                            <?php $stickerTypes=App\StickerCategory::all(); ?>
                            @if(isset($stickerTypes))
                            @foreach($stickerTypes as $stickerType)
                            <option value="{{$stickerType->value}}">{{$stickerType->value}}</option>
                            @endforeach
                            @endif
                        </select> &nbsp;&nbsp;
                        <label style="font-weight:bold;">From Date: </label>
                        <input class="form-control-sm from_date" placeholder="dd-mm-yy" type="text" style="border: none; padding: 2px 5px;" name="inspec_from_date" value="{{isset($inspec_from_date) ? $inspec_from_date : ''}}" autocomplete="off">
                        &nbsp;&nbsp;
                        <label style="font-weight:bold;">To Date: </label>
                        <input class="form-control-sm to_date" placeholder="dd-mm-yy" type="text" style="border: none; padding: 2px 5px;" name="inspec_to_date" value="{{isset($inspec_to_date) ? $inspec_to_date : ''}}" autocomplete="off">
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
                            <th scope="col">Name, NID</th>
                            <th scope="col">BA</th>
                            <th scope="col">Rank</th>
                            <th scope="col">Reg. No.</th>
                            <th scope="col">Phone No.</th>
                            <th scope="col">Apply Date</th>
                            <th scope="col">Delevery Date</th>
                            <th scope="col">Vehicle Type</th>
                            <th scope="col">Glass Type</th>
                            <th scope="col">Sticker Type</th>
                            <th scope="col">Present Address</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="example-wrapper-2"  style="padding: 0 15px;">
                    <table id="example-2" class="table table-bordered dt-responsive mt-4" style="text-align: center; width:100%;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Sticker Type</th>
                                <th scope="col">Deffence</th>
                                <th scope="col">Non-Deffence</th>
                                <th scope="col">Transparent</th>
                                <th scope="col">Not Transparent</th>
                                <th scope="col">MP DTE Approved</th>
                                {{-- new add --}}
                                <th scope="col">Free Discount</th>
                                {{-- new add --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($apps))
                                @php
                                    $total_def = 0;
                                    $total_non_def =  0;
                                    $total_transparent = 0;
                                    $total_not_transparent = 0;
                                    $total_ps_approved = 0;
                                    //new add
                                    $total_free_approved = 0;
                                @endphp
                                @foreach ($stickerTypes as $key => $sticker)

                                        @php
                                         
                                            
                                            if($inspec_from_date !='' && $inspec_to_date !=''){
												$frmDt	= date('Y-m-d', strtotime($inspec_from_date));
												$toDt	= date('Y-m-d', strtotime($inspec_to_date));
                                                // $applicaation_ids = App\ApplicationNotify::whereBetween('sticker_delivery_date', [date('Y-m-d', strtotime($inspec_from_date)), date('Y-m-d', strtotime($inspec_to_date))])->pluck('application_id');
                                               
                                                if ($sticker_category) {
                                                    $def = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['type'=>'def','sticker_category'=>$sticker_category])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                   
                                                    $non_def =  App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['type'=>'non-def','sticker_category'=>$sticker_category])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                    $transparent = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['glass_type'=>'transparent','sticker_category'=>$sticker_category])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                    $not_transparent = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['sticker_category'=>$sticker_category])->where('glass_type','!=','transparent')->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                    $ps_approved = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['ps_approved'=>1,'sticker_category'=>$sticker_category])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                //    new add
                                                    
                                                $free_approved = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['ps_approved'=>1,'sticker_category'=>$sticker_category])->where('issue_type', 'free')->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
												
                                                }else {
                                                  

												  $def = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['type'=>'def'])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
												 
                                                  $non_def =  App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['type'=>'non-def'])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                  $transparent = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['glass_type'=>'transparent'])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                  $ps_approved = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['ps_approved'=>1])->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                  $not_transparent = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['sticker_category'=>$sticker_category])->where('glass_type','!=','transparent')->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
                                                  //new add
                                                  $free_approved = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['ps_approved'=>1])->where('issue_type', 'free')->whereRaw("id IN (SELECT application_id FROM application_notifies WHERE sticker_delivery_date BETWEEN '$frmDt' AND '$toDt')")->count();
												
                                                }
                                                
                                            }else {
                                                $def = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['type'=>'def','sticker_category'=>$sticker->name])->count();
                                                $non_def =  App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['type'=>'non-def','sticker_category'=>$sticker->name])->count();
                                                $transparent = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['glass_type'=>'transparent','sticker_category'=>$sticker->name])->count();
                                                $not_transparent = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['sticker_category'=>$sticker->name])->where('glass_type','!=','transparent')->count();
                                                $ps_approved = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['ps_approved'=>1,'sticker_category'=>$sticker->name])->count();
                                                //new add
                                                $free_approved = App\application::whereIn('app_status', ['approved','PS approved'])->where(['sticker_category'=>$sticker->name])->where(['ps_approved'=>1,'sticker_category'=>$sticker->name])->where('issue_type', 'free')->count();
                                            }
                                            
                                            $total_def += $def;
                                            $total_non_def += $non_def;
                                            $total_transparent += $transparent;
                                            $total_not_transparent += $not_transparent;
                                            $total_ps_approved += $ps_approved;
                                            //new add
                                            $total_free_approved += $free_approved;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            <td>{{ $sticker->name }}</td>
                                            <td>
                                                {{ $def }}
                                            </td>
                                            <td>
                                                {{ $non_def }}
                                            </td>
                                            <td>
                                                {{ $transparent }}
                                            </td>
                                            <td>
                                                {{ $not_transparent }}
                                            </td>
                                            <td>
                                                {{ $ps_approved }}
                                            </td>
                                            {{-- new add --}}
                                            <td>
                                                {{ $free_approved }}
                                            </td>
                                        </tr>
                                @endforeach
                                
                                    <tr>
                                        <td class="text-right" colspan="2">
                                            <b>Total</b>
                                        </td>
                                        <td>
                                            <b>{{ $total_def }}</b>
                                        </td>
                                        <td>
                                            <b>{{ $total_non_def }}</b>
                                        </td>
                                        <td>
                                            <b>{{ $total_transparent }}</b>
                                        </td>
                                        <td>
                                            <b>{{ $total_not_transparent }}</b>
                                        </td>
                                        <td>
                                            <b>{{ $total_ps_approved }}</b>
                                        </td>

                                        {{-- new add
                                             --}}
                                             <td>
                                                <b>{{ $total_free_approved }}</b>
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
                    url: '{{ route('approved_apps.datatable') }}',
                    data: function (d) {
                        d.sticker_category = '{{ $sticker_category }}';
                        d.inspec_from_date = '{{ $inspec_from_date }}';
                        d.inspec_to_date = '{{ $inspec_to_date }}';

                        d.applicant_name = '{{ $applicant_name }}';
                        d.ba = '{{ $ba }}';
                        d.rank = '{{ $rank }}';
                        d.reg_no = '{{ $reg_no }}';
                        d.phone = '{{ $phone }}';
                        d.date = '{{ $date }}';
                        d.Vehicle_Type = '{{ $Vehicle_Type }}';
                        d.glass_type = '{{ $glass_type }}';
                        d.present_address = '{{ $present_address }}';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'id', searchable: false},
                    {data: 'applicant_name'},
                    {data: 'BA_no'},
                    {data: 'Rank_id'},
                    {data: 'Reg_number'},
                    {data: 'phone_number'},
                    {data: 'app_date'},
                    {data: 'sticker_delivery_date',orderable: false, searchable: false},
                    {data: 'vehicleType'},
                    {data: 'glass_type'},
                    {data: 'sticker_category'},
                    {data: 'address'},
                ],
                order:[[0,"desc"]]
            });

        });

    </script>

    <script type="text/javascript">
        function Print_approved_sticker_list(logo) { 
            var invTitle = $(".pptitle").text();
            var mywindow = window.open('', 'PRINT');
            var is_chrome = Boolean(mywindow.chrome);

            mywindow.document.write('<html><head style="padding:0; margin:0 auto"><title>'+invTitle+'</title>');

            mywindow.document.write('<style>table{max-width: 98%;font-size:13px;border-collapse:collapse;margin-bottom:35px;}table th,table td{max-width: 99%;padding:5px 5px;text-aligh:center;border:1px solid #ddd;}.footersign span{border-top:1px solid black;padding-top:5px;} table#example2{margin-bottom:15px} img { max-width: 100%; height: auto; }#adm-logo,.adm-logo{height:65px;width:65px;border-radius:50%;}#adm-logo.left{float:left;background-color: #ddd;}#adm-logo.right{float:right;background-color: transparent;}.custName{ min-width:150px;} a{text-decoration: none; color:#000;}.custDate{min-width:90px;}/*New css*/.p-heading{display:flex;flex-flow:row wrap;justify-content:space-between}.p-heading>div{width:auto}.p-heading .logo,.p-heading .qrcode{width:75px}.p-heading .logo img{width:100%;height:auto}.p-heading .ptitle{text-align:center}.p-heading .ptitle h3{ margin:0 0 5px;font-size: 20px;}.p-heading .ptitle h3,.p-heading .ptitle h4{margin-top:5px;font-weight:600;}.p-heading .ptitle h4{margin-top:15px;font-size:20px;margin-bottom:0;}.p-heading .ptitle p{margin:0 0 5px}/*New css*/.row{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.app-section{border:0px solid #e3e3e3;border-radius:0px;padding:0px 0px}.col-md-12{-webkit-box-flex:0;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}.col-md-3{-webkit-box-flex:0;-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}#app-review h5{background-color:#e4e4e4;border:1px solid #e4e4e4; line-height:1.2;font-size:20px;font-weight:700;border-radius:3px;padding:3px 15px 4px; margin-top: 0;} #app-review span,#app-review p{font-size:16px;padding-bottom:10px;display:inline-block;font-family:tahoma,helvetica,arial}.container-fluid{width:calc( 100% - 24px );padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.col-md-9{-webkit-box-flex:0;-ms-flex:0 0 75%;flex:0 0 75%;max-width:75%}.col-md-5{-webkit-box-flex:0;-ms-flex:0 0 41.666667%;flex:0 0 41.666667%;max-width:41.666667%}.col-md-4{-webkit-box-flex:0;-ms-flex:0 0 33.333333%;flex:0 0 33.333333%;max-width:33.333333%}.col-md-1{-webkit-box-flex:0;-ms-flex:0 0 8.333333%;flex:0 0 8.333333%;max-width:8.333333%}.modal-content{display:none}.text-center{text-align:center!important}.mt-3,.my-3{margin-top:1rem!important}.sta_address{border:1px solid #ddd;padding:0 10px;margin:0 0 12px;max-width:300px}.sta_address p.address-title{margin:0 -10px;padding:5px 10px!important;border-bottom:1px solid #ddd;width:calc(100% + 00px)}#app-review span b{font-weight:400}span#app_status{text-transform:capitalize}div.app-section{page-break-inside:avoid;margin-top:15px;}#app-review{margin-left: auto;margin-right: auto;} img#applicant_photo, .app-section img { max-width: 90px; max-height: 90px;}#example{margin-top:15px;}#example-2{margin-top:15px;}#example th,#example td,#example-2 th,#example-2 td{border:1px solid #000!important;font-family:Verdana;font-size:12px;padding: 8px;}.sto-wrap{ display:flex;justify-content:space-between;align-itmes:center;margin:65px 15px 15px;font-size:14px;font-weight: bold;flex-flow: row wrap;}.sto-wrap span{border-top: 1px solid #000;min-width:150px;text-align: center;padding-top:3px;;}</style>');
            mywindow.document.write('</head><body>');

            mywindow.document.write('<div class="p-heading"><div class="logo"><img src="'+logo+'" style="width:90px;margin-left: 30px;margin-top: 15px; height:auto" /></div><div class="ptitle" ><h3>Station Headquarters Dhaka Cantonment</h3><p>Shaheed Sharani, Dhaka, Bangladesh</p><p>Contact: 01797-585010</p><h4>All Approved Application</h4> <br></div><div class="qrcode"></div></div>');


        mywindow.document.write(document.getElementById('table').outerHTML); 

        mywindow.document.write('<div style="text-align:center;margin-top:15px;" ><h4 style="font-size:20px;margin:0;">Summary of All Approved Applications</h4></div>');  
            mywindow.document.write(document.getElementById('example-2').outerHTML);


        mywindow.document.write('<div class="sto-wrap" ><span>NCO</span> <span>STO</span> <span>Comd.</span></div>');  

            mywindow.document.write('</body></html>');

            if (is_chrome) {
                setTimeout(function () { // wait until all resources loaded 
                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10*/
                    mywindow.print();
                    mywindow.close();
                }, 250);
            }
            else {
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/
                mywindow.print();
                mywindow.close();
            }

            return true;
        }
        $(document).ready(function(){  
        // $(".dt-buttons.btn-group").empty();
        $("#printButton").on("click", function(){
            var logo = $("#adm-logo img").attr("src");
            Print_approved_sticker_list(logo);
            var invTitle = "All Approved Application";
        });
        
        });
        
    </script>
@endsection