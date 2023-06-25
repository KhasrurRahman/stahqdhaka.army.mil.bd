@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="pptitle"> Update Header & Footer Content </h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{session('success')}}
                    </div>
                @endif
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <div class="panel-body" style="padding:10px 0;">
                    <div id="example-wrapper">
                        <form action="{{ route('header_footer_store') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Telephone Number</label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="telephone" id="telephone" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->telephone }} @endisset">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Mobile Number</label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="mobile" id="mobile" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->mobile }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Fax Number</label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="fax" id="fax" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->fax }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Sicker Query </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="sticker_query" id="sticker_query" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->sticker_query }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Location </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="location" id="location" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->location }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Footer About </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="about" id="about" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->about }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Army Exch </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="army_exch" id="army_exch" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->army_exch }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Duty Clerk Mil </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="duty_clerk_mil" id="duty_clerk_mil" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->duty_clerk_mil }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Unique Visitor </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="unique_visitor" id="unique_visitor" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->unique_visitor }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Copyright text </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="copyright" id="copyright" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->copyright }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Breaking News </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="breaking_news" id="breaking_news" class="form-control in-form" value="@isset($header_footer) {{ $header_footer->breaking_news }} @endisset">
                                    </div>

                                </div>
                                <div class="col-md-12 text-center">
                                    <br><br>
                                    <button type="submit" class="btn btn-primary" id="confirm_add_sms"> Update </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

       </div>
        

    </div>

@endsection
@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>
@endsection