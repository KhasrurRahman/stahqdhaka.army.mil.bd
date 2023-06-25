@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <b class=""> Edit PDF File </b> 
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
                        <form action="{{ route('pdf_file.update', $pdf_file->id) }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> PDF File Name <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="name" id="name" class="form-control in-form" value="{{ old('name', $pdf_file->name) }}" required>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> PDF File Position <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="position" id="position" class="form-control in-form" value="{{ old('position', $pdf_file->position) }}" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> File Type <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="type" id="type" class="form-control select2 in-form">
                                            <option @if ($pdf_file->type== 'notice') selected @endif value="notice"> Notice </option>
                                            <option @if ($pdf_file->type== 'news_events') selected @endif value="news_events"> News & Events </option>
                                            <option @if ($pdf_file->type== 'policy') selected @endif value="policy"> Policy </option>
                                            <option @if ($pdf_file->type== 'forms') selected @endif value="forms"> Forms </option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> PDF File <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                    <p> Current File :  <a href="{{ asset('assets/pdf_files/'.$pdf_file->file) }}" target="_blank">{{ $pdf_file->file }}</a> </p>
                                        <input type="file" id="file" name="file" id="file" class="in-form">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Status <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="status" id="status" class="form-control in-form">
                                            <option @if ($pdf_file->status==1) selected @endif value="1">Enable</option>
                                            <option @if ($pdf_file->status==0) selected @endif value="0">Disable</option>
                                        </select>
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
        .pdf_file_image img{
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