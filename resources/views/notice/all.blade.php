@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
                <div class="panel panel-default">
                    <b>Notices</b>
{{--                    <a href="{{ route('website_notice.add') }}" class="btn btn-primary btn-sm pull-right"> Add Notice</a>--}}
                </div>
                @if(session('message'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{session('message')}}
                    </div>
                @endif
                <div class="panel-body" style="padding:10px 0;">
                    <table id="example" class="table table-bordered">
                        <thead>
                        `   <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Link Status</th>
                                <th>Description</th>
                                <th>Files</th>
                                <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notices as $notice)
                            <tr>
                                <td>{{ $notice->sort }}</td>
                                <td>{{ $notice->title }}</td>
                                <td class="text-center"> {{ $notice->status == 1?'Enable':'Disable' }} </td>
                                <td class="text-center"> {{ $notice->link_active == 1?'Enable':'Disable' }} </td>
                                <td>{!! $notice->description !!}</td>
                                <td>
                                    @foreach($notice->files as $key => $file)
                                        <a target="_blank" href="{{ asset($file->pdf) }}">PDF{{ $key+1 }}</a>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('website_notice.edit',['notice'=>$notice->id]) }}" class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i></a>
                                    <!-- <a href="{{ route('website_notice.delete',['notice'=>$notice->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete ?')">
                                        <i class="fa fa-trash"></i>
                                    </a> -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>


    </div>

@endsection
@section('admin-script')
    <link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

    <script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>
@endsection