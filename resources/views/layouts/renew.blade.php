@extends('layouts.customer-master')
@section('content')
                     <div class="col-md-10" id="content_term_condition" style="margin-top:10px;">
                    @if(!empty($allocated_sticker))
                        @if($allocated_sticker->application->type=='def')
                                  @include('forms.apply-form-def')
                        @elseif($allocated_sticker->application->type == 'non-def')
                                 @include('forms.apply-form-non-def')
                        @endif
                    @endif
                    </div>
    @endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/js/applyform.js') }}"></script>
@endsection

