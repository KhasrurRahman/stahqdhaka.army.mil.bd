@extends('layouts.customer-master')
@section('content')
    <div class="col-md-10" id="content_term_condition" style="margin-top:10px; ">
        <div class="content-area" style="padding-top: 15px;">
            <div class="container-fluid  pl-0 pr-0">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="pptitle">Your Applications for Vehicle Sticker</h3>
                    </div>
                    <div class="panel-body" style="padding:15px;">
                        @if ($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Not Allowed!</strong> {{ $errors->first() }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div id="example-wrapper">
                            <table id="example" class="table table-bordered dt-responsive" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Reg. No.</th>
                                        <th scope="col">Phone No.</th>
                                        <th scope="col">Apply Date</th>
                                        <th scope="col">Vehicle Type</th>
                                        <th scope="col">Nat ID</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset(auth()->guard('applicant')->user()->applications))
                                        <?php $sl = 1; ?>
                                        @foreach (auth()->guard('applicant')->user()->applications->sortByDesc('created_at')->where('app_status', '!=', 'processing') as $key => $app)
                                            <tr>
                                                <th scope="row">{{ $sl++ }}</th>
                                                <td>
                                                    {{ !empty($app->applicant->name) ? $app->applicant->name : '' }}</td>
                                                <td>{{ !empty($app->vehicleinfo->reg_number) ? $app->vehicleinfo->reg_number : '' }}
                                                </td>
                                                <td>{{ !empty($app->applicant->phone) ? $app->applicant->phone : '' }} </td>
                                                <td>{{ !empty($app->app_date) ? $app->app_date : '' }}</td>
                                                <td>{{ !empty($app->vehicleinfo->vehicleType->name) ? $app->vehicleinfo->vehicleType->name : '' }}
                                                </td>
                                                <td>{{ isset($app->applicant->applicantDetail->nid_number) ? $app->applicant->applicantDetail->nid_number : '-' }}
                                                </td>
                                                <td>
                                                    @if (!empty($app->app_status))
                                                        @if ($app->app_status == 'forwarded to PS')
                                                            Forwarded To MP DTE
                                                        @else
                                                            {{ $app->app_status }}
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>
                                                      {{-- new changes replace old --}}
                                                    @if ($app->payment_status == '0')
                                                        @if($app->issue_type == "free")
                                                        <button class="btn btn-success btn-sm">Free</button>
                                                        @else
                                                        <button class="btn btn-danger btn-sm">Unpaid</button>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-success btn-sm">Paid</button>
                                                    @endif
                                                      {{-- new changes replace old --}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info"
                                                        href="{{ url('/application/edit/applicant') }}/{{ $app->app_number }}">
                                                        Edit </a>
                                                    <a class="btn btn-success"
                                                        href="{{ url('/application/view/applicant') }}/{{ $app->app_number }}">
                                                        View </a>

                                                    @if ($app->payment_status == '0' && $app->app_status == 'approved')
                                                        <?php
                                                        $ids = str_split($app->id);
                                                        //dd($ids);
                                                        $mapping_id_special = [
                                                            0 => 'Ya',
                                                            1 => 'Is',
                                                            2 => 'Pa',
                                                            3 => 'Nq',
                                                            4 => 'MV',
                                                            5 => 'rD',
                                                            6 => 'QH',
                                                            7 => 'Lm',
                                                            8 => 'Nb',
                                                            9 => 'Ei',
                                                        ];
                                                        $encryptedId = '';
                                                        foreach ($ids as $key => $value) {
                                                            $encryptedId = $encryptedId . $mapping_id_special[$value];
                                                        }
                                                        ?>
                                                        @if($app->issue_type == "free")
                                                        <button class="btn btn-primary">Free</button>
                                                        @else
                                                        <a class="btn btn-warning"
                                                            href="{{ route('payment.view', $encryptedId) }}">Pay
                                                            now</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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
