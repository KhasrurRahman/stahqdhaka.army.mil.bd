@extends('layouts.customer-master')
@section('content')
                  <div class="col-md-10" id="content_term_condition" style="margin-top:10px;">
                    <div class="container-fluid">
                      <div style="width: 93.5%; height: 56px; background-color: #dededea8; color: #000000b8; padding: 5px 10px; margin-left: 8px; border-radius: 5px; text-align: center;">
                        <h2 style="font-weight: 700;text-transform: capitalize;margin: 9px 0;color: #000">Please read the terms and conditions before applying...</h2>
                      </div>
                    </div>
                      <iframe src="{{ secure_asset('assets/images/fixed_files/'.$all_fixed_file->sticker_policy) }}" height="600px" class="ml-4 col-md-11" style="padding: 0;margin-bottom:10px;">
                      </iframe>
                    <div class="row mt-2">
                      <div class="col-md-6" >
                        <div style="display:flex; align-items: center;flex-flow: row wrap;">
                        <input type="checkbox" placeholder=""  id="term_checkbox" style="width: 18px; height: 18px;margin-left: 25px;"> 
                        <label for="term_checkbox" style="padding-left:6px;margin: 0; color:#f11414; font-size: 20px;cursor: pointer;" for=""> I accept the terms and conditions.</label>
                        </div>
                      </div>
                      <div class="col-md-2 offset-md-3">
                       <button disabled  id="next_btn"  class="btn btn-info btn-block">Next</button>
                     </div>
                   </div>
                  </div>
                  @if(auth()->guard('applicant')->user()->role=='def')
                  <div class="col-md-10" id="content_form_def" hidden>
                    @include('forms.apply-form-def')
                  </div>
                  @elseif(auth()->guard('applicant')->user()->role=='non-def')
                  <div class="col-md-10" id="content_form_non-def" hidden>
                    @include('forms.apply-form-non-def')
                  </div>
                  @endif
@endsection
@section('script')
<script type="text/javascript" src="{{secure_asset('assets/js/applyform.js') }}"></script>

@endsection
