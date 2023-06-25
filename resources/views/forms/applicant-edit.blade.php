@extends('layouts.customer-master')
@section('content')
<div class="col-md-10" id="content_term_condition" style="margin-top:0px; ">  	
        <div class="content-area" style="padding-top: 0px;">
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
</div>
@endsection
@section('script')
 <script type="text/javascript" src="{{asset('assets/js/applyform.js') }}"></script>

@endsection