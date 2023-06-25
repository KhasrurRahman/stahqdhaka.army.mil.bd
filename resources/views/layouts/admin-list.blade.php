@extends('layouts.admin-master')
@section('admin-sidebar')
@include('layouts.admin-sidebar')
@endsection
@section('content')
<div class="content-area admin-list-panel" style="padding-top: 15px;">
	<div class="container-fluid  pl-0 pr-0" >
		<div class="panel panel-default">
			<div class="panel-heading" style=" display: flex;justify-content: flex-start;align-items: center;    flex-flow: row wrap;">
				<h3 class="pptitle">All Admins </h3>
				<button id='add_new_Admin' data-toggle="modal" data-target="#Add_template_modal" class="btn btn-primary" style="overflow: hidden; margin: 0 25px;"><i class="fas fa-plus"></i> &nbsp; Add New Admin</button>
			</div>
			<div class="panel-body" style="padding:10px 0;">
				<div id="example-wrapper">
					<table id="example" class="table table-bordered dt-responsive" style="text-align:center;">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Role</th>
								<th scope="col">Created_at</th>
								<th scope="col" class="action">Action</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($admins) && count($admins)>0)
							@foreach($admins as $admin)
							<tr id="sms-{{$admin->id}}">
								<td>{{$loop->iteration}}</td>
								<td>{{$admin->name}}</td>
								<td>{{$admin->email}}</td>
								<td>{{$admin->role}}</td>
								<td>{{$admin->created_at}}</td>
								<td class="action" style="text-align: center;">
									<button class="btn btn-info edit-admin" data-name="{{$admin->name}}" data-email="{{$admin->email}}" data-role="{{$admin->role}}" data-id="{{$admin->id}}" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i>
									</button>
									<button class="btn btn-danger delete-admin" data-id="{{$admin->id}}" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i>
									</button>
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
				<legend style="color:#fff; text-align: center; ">Add new admin user </legend>
				<button style="color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="padding:10px 10px 0 0;">&times;</span>
				</button>
			</div>
			<div class="alert alert-danger print-error-msg" style="display:none">
				<ul></ul>
			</div>
			<form id="AddAdmin_Form">
				{{csrf_field()}}
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">Name</label><span>*</span> <br>
							<input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="name">
							@if ($errors->has('name'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif
						</div>
						<div class="col-md-3 offset-md-1">
							<label>Email</label> <span style="color: red;">*</span>
							<input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="mail@example.com">
							@if ($errors->has('email'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">Role</label><span>*</span> <br>
							<input type="text" name="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" placeholder="role" value="admin" readonly>
							@if ($errors->has('role'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('role') }}</strong>
							</span>
							@endif
						</div>
						<div class="col-md-3 offset-md-1">
							<label>Password</label> <span style="color: red;">*</span>
							<input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Create a password" AUTOCOMPLETE="off">
						</div>
						<div class="col-md-3 offset-md-1">
							<label>Confirm Password</label> <span style="color: red;">*</span>
							<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" AUTOCOMPLETE="off">
							@if ($errors->has('password'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
							@endif
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary" id="confirm_add_admin">Add New Admin</button>
				</div>
			</form>
		</div>
	</div>
</div> 
<!-- Edit SMS Template Modal -->
<div class="modal fade" id="edit_template_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
			<form id="UpdateAdmin_Form">
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
							<label for="" class="label-form">Email</label><span>*</span> <br>
						</div>
						<div class="col-md-8">
							<input type="text" name="email" id="email" class="form-control in-form email" value="">
						</div>
						<div class="col-md-3 offset-md-1">
							<label for="" class="label-form">Role</label><span>*</span> <br>
						</div>
						<div class="col-md-8">
							<input type="text" name="role" id="role" class="form-control in-form role" value="admin" readonly>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary" id="confirm_update_admin">Update Admin</button>
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