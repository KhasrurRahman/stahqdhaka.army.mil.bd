@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
<div class="content-area sticker-list-panel" style="padding-top: 15px;">
  <div class="container-fluid  pl-0 pr-0" >
    <div class="panel panel-default">
      <div class="panel-heading" style=" display: flex;justify-content: flex-start;align-items: center;    flex-flow: row wrap;">
        <h3 class="pptitle">All Sticker Types</h3>
        <button id='add_new_Sms' data-toggle="modal" data-target="#Add_template_modal" class="btn btn-primary" style="overflow: hidden; margin: 0 25px;"><i class="fas fa-plus"></i> &nbsp; Add New Sticker Type</button>
      </div>
      <div class="panel-body" style="padding:10px 0;">
        <div id="example-wrapper">
          <table id="example" class="table table-bordered dt-responsive" style="text-align: center;">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">value</th>
                <th scope="col">Price (TK)</th>
                <th scope="col">Duration (Year)</th>
                <th scope="col">Created By</th>
                <th scope="col">Updated By</th>
                <th scope="col" class="action">Action</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($stickers))
              <?php $sl=1; ?>
              @foreach($stickers as $key => $sticker)
              <tr id="sticker-{{$sticker->id}}">
                <td scope="row"> <b class="serial">{{$sl++}} </b></td>
                <td>{{$sticker->name}}</td>
                <td>{{$sticker->value}}</td>
                <td>{{$sticker->price}}</td>
                <td>{{$sticker->duration}}</td>
                <td>{{!empty($sticker->created_by)?$sticker->created_by:''}} <br>
                  {{ \Carbon\Carbon::parse($sticker->created_at)->toDayDateTimeString()}}
                </td>
                <td>{{!empty($sticker->updated_by)?$sticker->updated_by:''}}<br>
                  {{ !empty($sticker->updated_by)?\Carbon\Carbon::parse($sticker->updated_at)->toDayDateTimeString():''}}
                </td>
                <td class="action">
                  <button class="btn btn-info edit-sticker" data-name="{{$sticker->name}}" data-value="{{$sticker->value}}" data-price="{{$sticker->price}}" data-duration="{{$sticker->duration}}" data-id="{{$sticker->id}}" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-danger delete-sticker" data-id="{{$sticker->id}}" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>
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
        <legend style="color:#fff; text-align: center; ">Add New Sticker Type </legend>
        <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
        </button>
      </div>
      <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
      </div>
      <form id="AddSticker_Form">
        {{csrf_field()}}
        <div class="modal-body">

          <div class="row">
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Sticker Type Name</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="text" name="name" id="name" class="form-control in-form" value="" required>
            </div>
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Sticker Symbol</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="text" name="value" id="value" class="form-control in-form" value="" required>
            </div>
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Price</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="number" name="price" id="price" class="form-control in-form" value="" required>
            </div> 
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Duration</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="number" name="duration" id="duration" class="form-control in-form" value="" required>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="confirm_add_sms">Add Sticker Type</button>
        </div>
      </form>
    </div>
  </div>
</div> 

<div class="modal fade" id="edit_template_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
        <legend style="color:#fff; text-align: center; ">Update Sticker Type </legend>
        <button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
        </button>
      </div>
      <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
      </div>
      <form id="UpdateSticker_Form">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Sticker Type Name</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="text" name="name" id="name1" class="form-control in-form sticker_name" value="" required="">
            </div>
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Sticker Symbol</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="text" name="value" id="value1" class="form-control in-form sticker_value" value="" required="">
            </div>
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Price</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="number" name="price" id="price1" class="form-control in-form sticker_price" value="" required="">
            </div> 
            <div class="col-md-3 offset-md-1">
              <label for="" class="label-form">Duration</label><span>*</span> <br>
              <small></small>
            </div>
            <div class="col-md-8">
              <input type="number" name="duration" id="duration1" class="form-control in-form sticker_duration" value="" required="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="confirm_update_sms">Update Sticker Type</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
@section('admin-script')
<link href="{{asset('assets/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

<script src="{{asset('assets/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/admins/js/admin-script.js')}}"></script>
@endsection