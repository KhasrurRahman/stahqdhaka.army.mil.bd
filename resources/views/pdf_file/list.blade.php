@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <b>PDF File List</b>
                <a href="{{ route('pdf_file.add') }}" class="btn btn-primary btn-sm pull-right"> Add New PDF File</a>
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
                        <th scope="col">File Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">File Type</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="action">Action</th>
                    </tr>
                    </thead>
                        @foreach ($all_pdf_files as $key => $pdf_file)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> 
                                    <a href="{{ asset('assets/pdf_files/'.$pdf_file->file) }}" target="_blank">{{ $pdf_file->name }}</a> 
                                </td>
                                <td class="text-center"> {{ $pdf_file->position }} </td>
                                <td class="text-center"> {{ ucfirst($pdf_file->type) }} </td>
                                <td class="text-center"> {{ $pdf_file->status == 1?'Enable':'Disable' }} </td>
                                <td class="text-center"> 
                                    <a href="{{ route('pdf_file.edit', $pdf_file->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ asset('assets/pdf_files/'.$pdf_file->file) }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pdf_file.delete', $pdf_file->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete ?')">
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