@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <b class=""> Add New PDF File </b> 
                    <a href="{{ route('pdf_file.list') }}" class="btn btn-primary btn-sm" style="float:right"> PDF File List</a>
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
                        <form action="{{ route('pdf_file.store') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> PDF File Name <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="name" id="name" class="form-control in-form" value="{{ old('name') }}" required>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> PDF File Position <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="position" id="position" class="form-control in-form" value="{{ old('position') }}" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> File Type <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <select name="type" id="type" class="form-control select2 in-form">
                                            <option value="notice"> Notice </option>
                                            <option value="news_events"> News & Events </option>
                                            <option value="policy"> Policy </option>
                                            <option value="forms"> Forms </option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> PDF File <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <input type="file" id="file" name="file" id="file" accept=".pdf" class="in-form" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Status <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <select name="status" id="status" class="form-control select2 in-form">
                                            <option value="1">Enable</option>
                                            <option value="0">Disable</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-12 text-center">
                                    <br><br>
                                    <button type="submit" class="btn btn-primary" id="confirm_add_sms"> Save </button>
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
            width: 280px;
            height: 104px;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 2px;
        }
    </style>
@endsection
@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>

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