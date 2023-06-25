@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
 <div class="content-area" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
        	@if(!empty($app))
                        @if($app->type == 'def' )
                                  @include('forms.apply-form-def-edit')
                        @elseif($app->type == 'non-def')
                                 @include('forms.apply-form-non-def-edit')
                        @endif
            @endif
        </div>
</div>
@endsection
@section('admin-script')
 <script type="text/javascript" src="{{asset('assets/js/applyform.js') }}"></script>

@endsection