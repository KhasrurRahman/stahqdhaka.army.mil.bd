@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
            <div class="panel-heading" style=" display: flex;justify-content: flex-start;align-items: center;    flex-flow: row wrap;">
                <h3 class="pptitle">All SMS Template</h3>
                <button id='add_new_Sms' data-toggle="modal" data-target="#Add_template_modal" class="btn btn-primary" style="overflow: hidden; margin: 0 25px;"><i class="fas fa-plus"></i> &nbsp; Add SMS Template</button>
            </div>
            <div class="panel-body" style="padding:10px 0;">
             <div id="example-wrapper">
                <table id="example" class="table table-bordered dt-responsive" style=":;">
                    <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Template</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Message</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Updated By</th>
                        <th scope="col" class="action">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($all_sms))
                    <?php $sl=1; ?>
                     @foreach($all_sms as $key => $sms)
                   <tr id="sms-{{$sms->id}}">
                       <td scope="row"> <b class="serial"> {{$sl++}} </b></td>
                        <td>{{$sms->sms_template_name}}</td>
                        <td>{{$sms->sms_subject}}</td>
                        <td>
                                @if(strlen($sms->sms_text)<=50)
                                 {{substr($sms->sms_text, 0, 50)}}
                                @else
                                 {{substr($sms->sms_text, 0, 50).' ...'}} 
                                @endif
                            </td>
                        <td>{{!empty($sms->creator)?$sms->creator:''}}</td>
                        <td>{{!empty($sms->updater)?$sms->updater:''}}</td>
                        <td class="action">
                            <button class="btn btn-info view-sms" data-template="{{$sms->sms_template_name}}" data-subject="{{$sms->sms_subject}}" data-message="{{$sms->sms_text}}" data-id="{{$sms->id}}" data-toggle="modal" data-target="#view_template_modal"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-info edit-sms" data-template="{{$sms->sms_template_name}}" data-subject="{{$sms->sms_subject}}" data-message="{{$sms->sms_text}}" data-id="{{$sms->id}}" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger delete-sms" data-id="{{$sms->id}}" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>
                        </td>
                   </tr>
                       @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
            </div>
        </div>

       </div>
        

    </div>
  
          <!-- Add SMS Template Modal -->
                                  <div class="modal fade" id="Add_template_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                         <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
                                          <legend style="color:#fff; text-align: center; ">Add SMS To Notify User </legend>
                                          <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
                                        </button>
                                        </div>
                                          <div class="alert alert-danger print-error-msg" style="display:none">
                                            <ul></ul>
                                        </div>
                                        <form id="AddSms_Form">
                                          {{csrf_field()}}
                                        <div class="modal-body">

                                         <div class="row">

                                           <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">SMS Template Name</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                            <input type="text" name="sms_template_name" id="sms_template_name" class="form-control in-form" value="">
  
                                           </div>
                                            <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Subject</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                              <input type="text" name="sms_subject" id="sms_subject" class="form-control in-form" value="">
                                           </div> 
                                            <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Message</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                              <textarea type="text" rows='5' id="sms_text"  name="sms_text" class="form-control in-form" ></textarea>
                                          </div>
                                          
                                       </div>
                                     </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary" id="confirm_add_sms">Add SMS Template</button>
                                        </div>
                                      </form>
                                      </div>
                                    </div>
                                  </div> 
                                <!-- View SMS Template Modal -->
                                  <div class="modal fade" id="view_template_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                         <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
                                          <legend style="color:#fff; text-align: center; ">View SMS</legend>
                                          <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">

                                         <div class="row">

                                           <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">SMS Template Name</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                            <p class="sms-template"> </p>
  
                                           </div>
                                            <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Subject</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                              <p class="sms-subject"> </p>
                                           </div> 
                                            <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Message</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                              <p class="sms-text">  </p>
                                          </div>
                                          
                                       </div>
                                     </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div> 
                  <!-- Edit SMS Template Modal -->
                                  <div class="modal fade" id="edit_template_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                         <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
                                          <legend style="color:#fff; text-align: center; ">Update SMS To Notify User </legend>
                                          <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
                                        </button>
                                        </div>
                                       <div class="alert alert-danger print-error-msg" style="display:none">
                                            <ul></ul>
                                        </div>
                                        <form id="UpdateSms_Form">
                                          {{csrf_field()}}
                                        <div class="modal-body">

                                         <div class="row">

                                           <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">SMS Template Name</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                            <input type="text" name="sms_template_name" id="sms_template_name1" class="form-control in-form sms_template_name" value="">
  
                                           </div>
                                            <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Subject</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                              <input type="text" name="sms_subject" id="sms_subject1" class="form-control in-form sms_subject" value="">
                                           </div> 
                                            <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Message</label><span>*</span> <br>
                                            <small></small>
                                          </div>
                                          <div class="col-md-8">
                                              <textarea type="text" rows='5' id="sms_text1"  name="sms_text" class="form-control in-form sms_text" ></textarea>
                                          </div>
                                          
                                       </div>
                                     </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary" id="confirm_update_sms">Update SMS Template</button>
                                        </div>
                                      </form>
                                      </div>
                                    </div>
                                  </div>
                             <!-- Delete Sms Modal -->     
                       <!--      <div class="modal fade" id="delete_template_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                         <h4 class="modal-title" id="myModalLabel">Confirm Delete SMS Template</h4>

                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>You are about to delete this SMS template, this procedure is irreversible.</p>
                                        <p>Do you want to proceed?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <form id="deleteSms_Form">
                                          {{csrf_field()}}
                                          <button type="submit" class="btn btn-danger btn-ok">Delete</button>
                                          
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> -->

@endsection
@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>
@endsection