@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <b>MIL OFFRS List</b>
                <a href="{{ route('major.add') }}" class="btn btn-primary btn-sm pull-right"> Add New MIL OFFRS</a>
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
                        <th scope="col">MIL OFFRS</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Telephone</th>
                        <th scope="col">Position</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="action">Action</th>
                    </tr>
                    </thead>
                        @foreach ($majors as $key => $major)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ $major->name }} , {{ $major->rank }} </td>
                                <td class="text-center"> {{ $major->mobile }} </td>
                                <td class="text-center"> {{ $major->telephone }} </td>
                                <td class="text-center"> {{ $major->position }} </td>
                                <td class="text-center"> 
                                    <a href="{{ asset('assets/images/majors/'.$major->image) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ $major->image? asset('assets/images/majors/'.$major->image): asset('assets/images/majors/no_image.png') }}" alt="Image" style="height:50px;">
                                    </a>
                                </td>
                                <td class="text-center"> {{ $major->status == 1?'Enable':'Disable' }} </td>
                                <td class="text-center"> 
                                    <a href="{{ route('major.edit', $major->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('major.delete', $major->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete ?')">
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