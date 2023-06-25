@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
<div class="content-area" style="padding-top: 15px;">
	<div class="container-fluid pl-0 pr-0">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="pptitle">Client Lists</h3>
			</div>
			<div class="panel-body" style="padding:10px 0;">
				<div id="example-wrapper">

					<table id="datatable" class="table table-bordered dt-responsive" style="text-align: center; width:100%;">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Full Name</th>
								<th scope="col">User Name</th>
								<th scope="col">Email</th>
								<th scope="col">Phone</th>
								<th scope="col">Type</th>
								<th scope="col">Action</th>
							</tr>
						</thead>

					</table>
				</div>
			</div>
		</div>

	</div>


</div>

<!-- Edit SMS Template Modal -->
<div class="modal fade" id="edit_client_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #4785c7; padding: 10px 0;">
				<legend style="color:#fff; text-align: center; ">Update user info</legend>
				<button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
				</button>
			</div>
			<div class="alert alert-danger print-error-msg" style="display:none">
			</div>
			<form id="UpdateClient_Form">
				{{csrf_field()}}
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">Name</label><span>*</span> <br>
						</div>
						<div class="col-md-8">
							<input type="text" name="name" id="name" class="form-control in-form name" value="">
						</div>
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">User Name</label><span>*</span> <br>
						</div>
						<div class="col-md-8">
							<input type="text" name="user_name" id="user_name" class="form-control in-form user_name" value="">
						</div>
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">Email</label><span>*</span> <br>
						</div>
						<div class="col-md-8">
							<input type="text" name="email" id="email" class="form-control in-form email" value="">
						</div>
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">Phone</label><span>*</span> <br>
						</div>
						<div class="col-md-8">
							<input type="text" name="phone" id="phone" class="form-control in-form phone" value="">
						</div>
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">Role</label><span>*</span> <br>
						</div>
						<div class="col-md-8">
							<!--<input type="text" name="role" id="role" class="form-control in-form role" value="">-->
							<select name="client_role" id="client_role_def" class="form-control in-form mandatory client_role_def" hidden >
								<option value="def" selected>Deffence</option>
								<option class='non-def' value="non-def">Non-Deffence</option>
							</select>
							<select name="client_role" id="client_role_nondef" class="form-control in-form mandatory client_role_nondef" hidden>
								<option value="def">Deffence</option>
								<option selected value="non-def">Non-Deffence</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary" id="confirm_update_client">Update Customer</button>
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
<script>
	$(document).ready(function () {
		$('#datatable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "/fetch_clients_records",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columns": [
			{data: 'rownum', name: 'rownum', searchable: false},
			{data: 'name', name: 'name'},
			{data: 'user_name', name: 'user_name'},
			{data: 'email', name: 'email'},
			{data: 'phone', name: 'phone'},
			{data: 'role', name: 'role'},
			{data: 'action', name: 'action',orderable: false, searchable: false}

			]	 
		});
	});
</script>
@endsection
