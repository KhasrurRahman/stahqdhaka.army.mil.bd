@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <b class=""> Edit MIL OFFRS </b> 
                    <a href="{{ route('major.list') }}" class="btn btn-primary btn-sm" style="float:right"> MIL OFFRS List</a>
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
                        <form action="{{ route('major.update', $major->id) }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> MIL OFFRS Name <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="name" id="name" class="form-control in-form" value="{{ old('name', $major->name) }}" required>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Rank <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="rank" id="rank" class="form-control in-form" value="{{ old('rank', $major->rank) }}" required>
                                    </div>
                                    {{-- ---new ba and sso add-- --}}
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> BA <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="ba" id="ba" class="form-control in-form" value="{{ old('ba', $major->ba) }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> SSO <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="sso" id="sso" class="form-control in-form" value="{{ old('sso', $major->sso) }}" required>
                                    </div>
                                    {{-- ---new ba and sso add-- --}}
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Mobile <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="mobile" id="mobile" class="form-control in-form" value="{{ old('mobile', $major->mobile) }}" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Telephone <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="telephone" id="telephone" class="form-control in-form" value="{{ old('telephone', $major->telephone) }}" required>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Sorting Position <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="position" id="position" class="form-control in-form" value="{{ old('position', $major->position) }}" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> MIL OFFRS Image <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <div class="slider_image">
                                            <img id="image_show" src="@isset($major) {{ asset('assets/images/majors/'.$major->image) }} @else {{ asset('assets/images/no_image.png') }} @endisset" alt="Slider Image">
                                        </div>
                                        <input type="file" id="image" name="image" id="image" class="in-form">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Status <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <select name="status" id="status" class="form-control select2 in-form">
                                            <option @if ($major->status == 1) selected @endif value="1">Enable</option>
                                            <option @if ($major->status == 0) selected @endif value="0">Disable</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Short Description </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <textarea name="short_description" id="short_description" class="form-control" rows="3"> {!! old('short_description',$major->short_description) !!} </textarea>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Responsibility </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <textarea name="responsibility" id="responsibility" class="form-control" rows="10"> {!! old('responsibility', $major->responsibility) !!} </textarea>
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
        .slider_image img{
            width: 236px;
            height: 295px;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 2px;
        }
    </style>
@endsection
@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/ckeditor/ckeditor.js')}}"></script>

<script>
    // CK editor
     CKEDITOR.replace( 'responsibility' );
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