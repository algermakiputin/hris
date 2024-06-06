@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Appointments</h3>
	</div> 
	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Appointments</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>All Appointments</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content"> 
				<table class="table table-striped table-bordered" id="admin_appointments_table">
					<thead>
						<tr>
							<th>Campus</th>
							<th>Name</th>
							<th>Department/Office</th>
							<th>Designation</th> 
							<th>Time & Date</th>
							<th>Reason</th>
							<th>Status</th> 
							<th></th>
						</tr>
					</thead> 
					<tbody> 
					</tbody>
				</table>
				<form>
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
				</form>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div> 
@endsection

<div class="modal fade" id="update-appointment-status-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-info-circle"></i> <span id="leave-title">Update Appointment</span> </h4>
			</div>
			<div class="modal-body"> 
				{{ Form::open(['url' => '/appointments/update']) }}
					<input type="hidden" name="id" id="appointment-id" />
					<div class="form-group">
						<label>Status</label>
						<select name="status" id="appointment-status" class="form-control">
							<option>Pending</option>
							<option>Approved</option>
							<option>Rejected</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Update" />
					</div>
				{{ Form::close() }}
			</div> 
		</div>
	</div>
</div>