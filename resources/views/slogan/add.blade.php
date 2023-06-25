@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="pptitle"> Slogan </h3>
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
                        <form action="{{ route('slogan.store') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Slogan Text 1</label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="text1" id="text1" class="form-control in-form" value="@isset($slogan) {{ $slogan->text1 }} @endisset">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Slogan Text 2 </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="text2" id="text2" class="form-control in-form" value="@isset($slogan) {{ $slogan->text2 }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Background Image </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <div class="slogan_image">
                                            <img id="image_show" src="@isset($slogan->image) {{ asset('assets/images/sthq/'.$slogan->image) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Slogan Image">
                                        </div>
                                        <input type="file" id="image" name="image" id="image" class="in-form">
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
        .slogan_image img{
            width: 400px;
            height: 200px;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 2px;
        }
    </style>
@endsection

@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>

 <script>
    // Image Preview
    $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function(){
            readURL(this);
        });
    });
 </script>
@endsection