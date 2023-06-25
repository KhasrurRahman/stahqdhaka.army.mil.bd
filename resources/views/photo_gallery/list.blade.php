@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <b>Photo Gallery List</b>
                <a href="{{ route('photo_gallery.add') }}" class="btn btn-primary btn-sm pull-right"> Add New Photo Gallery</a>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{session('success')}}
                </div>
            @endif
            <div class="panel-body">
             <div id="example-wrapper">
                <table id="example" class="table table-bordered dt-responsive" >
                    <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Photo Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="action">Action</th>
                    </tr>
                    </thead>
                        @foreach ($photo_galleries as $key => $photo_gallery)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ $photo_gallery->name }} </td>
                                <td class="text-center"> {{ $photo_gallery->position }} </td>
                                <td class="text-center"> 
                                    <a href="{{ asset('assets/images/photo_galleries/'.$photo_gallery->image) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ $photo_gallery->image? asset('assets/images/photo_galleries/'.$photo_gallery->image): asset('assets/images/photo_gallerys/no_image.png') }}" alt="Image" style="height:50px;">
                                    </a>
                                </td>
                                <td class="text-center"> {{ $photo_gallery->status == 1?'Enable':'Disable' }} </td>
                                <td class="text-center"> 
                                    <a href="{{ route('photo_gallery.edit', $photo_gallery->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('photo_gallery.delete', $photo_gallery->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete ?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    <tbody>
                    </tbody>
                </table>
            </div>
            </div>
        </div>

       </div>
        

    </div>

@endsection
@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
 {{-- <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script> --}}
@endsection