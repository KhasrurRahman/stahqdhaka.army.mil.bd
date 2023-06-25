@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="pptitle"> Update Fixed file </h3>
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
                        <form action="{{ route('fixed_file.store') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Graveyard Allotment </label> <br>
                                        File Link : @isset($fixed_file->graveyard_allotment) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->graveyard_allotment) }}" target="_blank"> {{ $fixed_file->graveyard_allotment }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="graveyard_allotment_show" src="@isset($fixed_file->graveyard_allotment) {{ asset('assets/images/fixed_files/'.$fixed_file->graveyard_allotment) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Graveyard Allotment">
                                        </div>
                                        <input type="file" id="graveyard_allotment" name="graveyard_allotment" id="graveyard_allotment" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Bus Service </label> <br>
                                        File Link : @isset($fixed_file->bus_service) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->bus_service) }}" target="_blank"> {{ $fixed_file->bus_service }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="bus_service_show" src="@isset($fixed_file->bus_service) {{ asset('assets/images/fixed_files/'.$fixed_file->bus_service) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Bus Service">
                                        </div>
                                        <input type="file" id="bus_service" name="bus_service" id="bus_service" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Private Service </label> <br>
                                        File Link : @isset($fixed_file->private_car) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->private_car) }}" target="_blank"> {{ $fixed_file->private_car }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="private_car_show" src="@isset($fixed_file->private_car) {{ asset('assets/images/fixed_files/'.$fixed_file->private_car) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Private Service">
                                        </div>
                                        <input type="file" id="private_car" name="private_car" id="private_car" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Anti malaria Drive </label> <br>
                                        File Link : @isset($fixed_file->anti_malaria_drive) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->anti_malaria_drive) }}" target="_blank"> {{ $fixed_file->anti_malaria_drive }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="anti_malaria_drive_show" src="@isset($fixed_file->anti_malaria_drive) {{ asset('assets/images/fixed_files/'.$fixed_file->anti_malaria_drive) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Anti malaria Drive">
                                        </div>
                                        <input type="file" id="anti_malaria_drive" name="anti_malaria_drive" id="anti_malaria_drive" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Drainage and Cleaning </label> <br>
                                        File Link : @isset($fixed_file->drainage_and_cleaning) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->drainage_and_cleaning) }}" target="_blank"> {{ $fixed_file->drainage_and_cleaning }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="drainage_and_cleaning_show" src="@isset($fixed_file->drainage_and_cleaning) {{ asset('assets/images/fixed_files/'.$fixed_file->drainage_and_cleaning) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Drainage and Cleaning">
                                        </div>
                                        <input type="file" id="drainage_and_cleaning" name="drainage_and_cleaning" id="drainage_and_cleaning" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Disposal of Garbage </label> <br>
                                        File Link : @isset($fixed_file->disposal_of_garbage) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->disposal_of_garbage) }}" target="_blank"> {{ $fixed_file->disposal_of_garbage }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="disposal_of_garbage_show" src="@isset($fixed_file->disposal_of_garbage) {{ asset('assets/images/fixed_files/'.$fixed_file->disposal_of_garbage) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Disposal of Garbage">
                                        </div>
                                        <input type="file" id="disposal_of_garbage" name="disposal_of_garbage" id="disposal_of_garbage" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> MP Checkpost </label> <br>
                                        File Link : @isset($fixed_file->mp_checkpost) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->mp_checkpost) }}" target="_blank"> {{ $fixed_file->mp_checkpost }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="mp_checkpost_show" src="@isset($fixed_file->mp_checkpost) {{ asset('assets/images/fixed_files/'.$fixed_file->mp_checkpost) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="MP Checkpost">
                                        </div>
                                        <input type="file" id="mp_checkpost" name="mp_checkpost" id="mp_checkpost" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Shuttle Service </label> <br>
                                        File Link : @isset($fixed_file->shuttle_service) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->shuttle_service) }}" target="_blank"> {{ $fixed_file->shuttle_service }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="shuttle_service_show" src="@isset($fixed_file->shuttle_service) {{ asset('assets/images/fixed_files/'.$fixed_file->shuttle_service) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Shuttle Service">
                                        </div>
                                        <input type="file" id="shuttle_service" name="shuttle_service" id="shuttle_service" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Other Service </label> <br>
                                        File Link : @isset($fixed_file->other_services) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->other_services) }}" target="_blank"> {{ $fixed_file->other_services }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="other_services_show" src="@isset($fixed_file->other_services) {{ asset('assets/images/fixed_files/'.$fixed_file->other_services) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Other Service">
                                        </div>
                                        <input type="file" id="other_services" name="other_services" id="other_services" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> General Contact Info </label> <br>
                                        File Link : @isset($fixed_file->contact_info) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->contact_info) }}" target="_blank"> {{ $fixed_file->contact_info }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="contact_info_show" src="@isset($fixed_file->contact_info) {{ asset('assets/images/fixed_files/'.$fixed_file->contact_info) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Contact Info">
                                        </div>
                                        <input type="file" id="contact_info" name="contact_info" id="contact_info" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Helpline </label> <br>
                                        File Link : @isset($fixed_file->helpline) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->helpline) }}" target="_blank"> {{ $fixed_file->helpline }} </a>  @endisset  <br>
                                        <div class="image_box">
                                            <img id="helpline_show" src="@isset($fixed_file->helpline) {{ asset('assets/images/fixed_files/'.$fixed_file->helpline) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Helpline">
                                        </div>
                                        <input type="file" id="helpline" name="helpline" id="helpline" class="in-form">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Sticker Policy </label> <br>
                                        File Link : @isset($fixed_file->sticker_policy) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->sticker_policy) }}" target="_blank"> {{ $fixed_file->sticker_policy }} </a>  @endisset  <br>
                                        <input type="file" id="sticker_policy" name="sticker_policy" id="sticker_policy" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Graveyard Policy </label> <br>
                                        File Link : @isset($fixed_file->graveyard_policy) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->graveyard_policy) }}" target="_blank"> {{ $fixed_file->graveyard_policy }} </a>  @endisset <br>
                                        <input type="file" id="graveyard_policy" name="graveyard_policy" id="graveyard_policy" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Graveyard Application Form </label> <br>
                                        File Link : @isset($fixed_file->graveyard_application) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->graveyard_application) }}" target="_blank"> {{ $fixed_file->graveyard_application }} </a>  @endisset <br>
                                        <input type="file" id="graveyard_application" name="graveyard_application" id="graveyard_application" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Sign Up Tutorial </label> <br>
                                        File Link : @isset($fixed_file->sign_up_tutorial) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->sign_up_tutorial) }}" target="_blank"> {{ $fixed_file->sign_up_tutorial }} </a>  @endisset <br>
                                        <input type="file" id="sign_up_tutorial" name="sign_up_tutorial" id="sign_up_tutorial" class="in-form">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="label-form"> Sticker Tutorial </label> <br>
                                        File Link : @isset($fixed_file->sticker_tutorial) <a href="{{ asset('assets/images/fixed_files/'.$fixed_file->sticker_tutorial) }}" target="_blank"> {{ $fixed_file->sticker_tutorial }} </a>  @endisset <br>
                                        <input type="file" id="sticker_tutorial" name="sticker_tutorial" id="sticker_tutorial" class="in-form">
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
@section('style')
    <style>
        .image_box img{
            width: 100px;
            height: 110px;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 2px;
        }
        label{font-weight: bold;}
    </style>
@endsection
@section('admin-script')

<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/ckeditor/ckeditor.js')}}"></script>
 <script>
     // CK editor
     CKEDITOR.replace( 'description' );
    // graveyard_allotment Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#graveyard_allotment_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#graveyard_allotment").change(function(){
            readURL(this);
        });
    });
    // bus_service Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#bus_service_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#bus_service").change(function(){
            readURL(this);
        });
    });
    // private_car Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#private_car_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#private_car").change(function(){
            readURL(this);
        });
    });
    // anti_malaria_drive Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#anti_malaria_drive_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#anti_malaria_drive").change(function(){
            readURL(this);
        });
    });
    // drainage_and_cleaning Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#drainage_and_cleaning_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#drainage_and_cleaning").change(function(){
            readURL(this);
        });
    });
    // disposal_of_garbage Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#disposal_of_garbage_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#disposal_of_garbage").change(function(){
            readURL(this);
        });
    });
    // mp_checkpost Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#mp_checkpost_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#mp_checkpost").change(function(){
            readURL(this);
        });
    });
    // shuttle_service Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#shuttle_service_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#shuttle_service").change(function(){
            readURL(this);
        });
    });
    // other_services Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#other_services_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#other_services").change(function(){
            readURL(this);
        });
    });
    // contact_info Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#contact_info_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#contact_info").change(function(){
            readURL(this);
        });
    });
    // helpline Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#helpline_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#helpline").change(function(){
            readURL(this);
        });
    });
</script>
@endsection