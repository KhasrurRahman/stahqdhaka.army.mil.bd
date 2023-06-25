@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('style')
    <style>
        .in-form{
            width: 100%;
        }
        a#btn-pdf {
            color: #fff;
        }

        a.btn.btn-danger.btn-sm.btn-remove {
            color: #fff;
        }
    </style>
@stop
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="pptitle"> Notice Add </h3>
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
                        <form action="{{ route('website_notice.add') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="title" class="label-form"> Title <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="title" placeholder="Title" id="title" class="form-control in-form" value="{{ old('title') }}" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="sort" class="label-form"> Sort <span class="text-danger">*</span> </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="sort" placeholder="Enter Sort" id="sort" class="form-control in-form" value="{{ old('sort') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Description </label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <br>
                                        <textarea name="description" id="description" class="form-control" rows="10"> {{ old('description') }}</textarea>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="link_active" class="label-form"> Link Active <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="link_active" id="link_active" class="form-control select2 in-form">
                                            <option  value="1">Enable</option>
                                            <option value="0">Disable</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="label-form"> Status <span class="text-danger">*</span></label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="status" id="status" class="form-control select2 in-form">
                                            <option  value="1">Enable</option>
                                            <option  value="0">Disable</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="file-container" id="file-container">
                                            <div class="file-item row mt-4">
                                                <div class="col-md-3">
                                                    <label for="" class="label-form"> PDF </label><a role="button" class="btn btn-danger btn-sm btn-remove">X</a> <br>
                                                    <small></small>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="file" name="pdf[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 offset-3" style="padding-left:0;">
                                            <a class="btn btn-primary btn-sm" id="btn-pdf" role="button">Add More PDF +</a>
                                        </div>
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
@section('admin-script')
    <link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

    <script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/ckeditor/ckeditor.js')}}"></script>
    <script>
        $(function (){

            // CK editor
            CKEDITOR.replace( 'description' );


            $('#btn-pdf').click(function () {
                var html = '<div class="file-item row mt-4"><div class="col-md-3"><label for="" class="label-form"> PDF <span class="text-danger">*</span> <a role="button" class="btn btn-danger btn-sm btn-remove">X</a></label> <br><small></small></div><div class="col-md-9"><input type="file" name="pdf[]" required></div></div>';
                var item = $(html);

                $('#file-container').append(item);


                if ($('.file-item').length >= 1 ) {
                    $('.btn-remove').show();
                }
            });

            $('body').on('click', '.btn-remove', function () {
                $(this).closest('.file-item').remove();

                if ($('.file-item').length <= 1 ) {
                    $('.btn-remove').hide();
                }
            });

            if ($('.file-item').length <= 1 ) {
                $('.btn-remove').hide();
            } else {
                $('.btn-remove').show();
            }
        });

    </script>
@endsection