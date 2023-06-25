@extends('layouts.admin-master')
@section('admin-sidebar')
    @include('layouts.admin-sidebar')
@endsection
@section('content')
    <div class="content-area sms-panel" style="padding-top: 15px;">
        <div class="container-fluid  pl-0 pr-0" >
            <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="pptitle">All Bank Deposits</h3>
                <button id='add_new_Sms' data-toggle="modal" data-target="#Add_bankDeposit_modal" class="btn btn-primary">Add Bank Deposit</button>
            </div>
            <div class="panel-body" style="padding:10px 0;">
             <div id="example-wrapper">
                <table id="example" class="table table-bordered dt-responsive" style=":;">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Depositor Name</th>
                        <th scope="col">Bank Name</th>
                        <th scope="col">Acc. No</th>
                        <th scope="col">Deposit Date</th>
                        <th scope="col">Creator</th>
                        <th scope="col">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($deposits))
                    <?php $sl=1; ?>
                     @foreach($deposits as $key => $deposit)
                   <tr>
                       <td scope="row"> <b class="serial"> {{$sl++}} </b></td>
                        <td>{{$deposit->depositor_name}}</td>
                        <td>{{$deposit->bank_name}}</td>
                        <td>{{$deposit->bank_acc_no}}</td>
                        <td>{{$deposit->deposit_date}}</td>
                        <td>{{$deposit->created_by}}</td>
                        <td>{{$deposit->amount}}</td>
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
      <div class="modal fade" id="Add_bankDeposit_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
             <form id="add_bank_deposit_Form">
              {{csrf_field()}}
                  <div class="row">
                     <div class="col-md-4 offset-md-1">
                        <label for="" class="label-form">Date</label> <span>*</span> <br>
                        <small></small>
                      </div>
                      <div class="col-md-7">
                          <input type="date" id="deposit_date" value="" name="deposit_date"  class="form-control in-form" placeholder="" required>
                    </div> 
                     <div class="col-md-4 offset-md-1">
                        <label for="" class="label-form">Bank Name</label> <span>*</span> <br>
                        <small></small>
                    </div>
                      <div class="col-md-7">
                          <input type="text" id="bank_name" value="" name="bank_name"  class="form-control in-form" placeholder="" required>
                    </div>  
                     <div class="col-md-4 offset-md-1">
                        <label for="" class="label-form">Bank Acc. No</label> <span>*</span> <br>
                        <small></small>
                    </div>
                      <div class="col-md-7">
                          <input type="text" id="bank_acc_no" value="" name="bank_acc_no"  class="form-control in-form" placeholder="" required>
                    </div>  
                      <div class="col-md-4 offset-md-1">
                        <label for="" class="label-form">Total Amount (in taka)</label> <span>*</span> <br>
                        <small></small>
                    </div>
                      <div class="col-md-7">
                          <input type="number" step='any' id="amount" value="" name="amount"  class="form-control in-form" placeholder="" required>
                    </div> 
                    <div class="col-md-4 offset-md-1">
                        <label for="" class="label-form">Depositor Name</label> <span>*</span> <br>
                        <small></small>
                      </div>
                      <div class="col-md-7">
                          <input type="text" id="depositor_name" value="" name="depositor_name"  class="form-control in-form" placeholder="" required>
                    </div> 
                    <div class="col-md-4 offset-md-1">
                    </div>
                      <div class="col-md-7 ">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-success custm-btn" 
                        id="Add_deposit">Add Bank Deposit</button>
                    </div>
                      
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
  