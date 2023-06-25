@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="pptitle"> Update present commander </h3>
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
                        <form action="{{ route('present_commander.store') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Heading Text </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="heading" id="heading" class="form-control in-form" value="@isset($present_commander) {{ $present_commander->heading }} @endisset">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Title Text </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="title" id="title" class="form-control in-form" value="@isset($present_commander) {{ $present_commander->title }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Rank </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="rank" id="rank" class="form-control in-form" value="@isset($present_commander) {{ $present_commander->rank }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Commander Name </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="name" id="name" class="form-control in-form" value="@isset($present_commander) {{ $present_commander->name }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> BA </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="ba" id="ba" class="form-control in-form" value="@isset($present_commander) {{ $present_commander->ba }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Telephone </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="telephone" id="telephone" class="form-control in-form" value="@isset($present_commander) {{ $present_commander->telephone }} @endisset">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Commander Photo <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <div class="commander_image">
                                            <img id="image_show" src="@isset($present_commander) {{ asset('assets/images/commander/'.$present_commander->image) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Present Commander Image">
                                        </div>
                                        <input type="file" id="image" name="image" id="image" class="in-form">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Description </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <textarea name="description" id="description" class="form-control" rows="10">@isset($present_commander) {{ $present_commander->description }} @endisset</textarea>
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
        .commander_image img{
            width: 170px;
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
 <script type="text/javascript" src="{{asset('/assets/ckeditor/ckeditor.js')}}"></script>
 <script>
     // CK editor
     CKEDITOR.replace( 'description' );
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