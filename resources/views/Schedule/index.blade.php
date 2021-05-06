@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Full Time Schedules</h3>
	</div>

	<nav aria-label="breadcrumb" class="nav navbar-right">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Leaves</li>
		</ol>
	</nav>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2 class="">Employee Schedules</h2>

				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table class="table table-hover table-striped table-bordered" id="schedules_table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Time-In</th>
							<th>Time-Out</th>
							<th>Days</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">New Schedule</h5>
			</div>
			<div class="modal-body">
				<form id="schedule_form">
					<div class="form-group">
						<label>Schedule Name</label>
						<input type="text" name="name" class="form-control" placeholder="Schedule Name">
					</div>
					<div class="form-group">
						<label>Start Time</label>
						<input type="text" name="start" class="schedule-time form-control" placeholder="Start Time">
					</div>
					<div class="form-group">
						<label>End Time</label>
						<input type="text" name="end" class="schedule-time form-control" placeholder="End Time">
					</div>
					<div class="form-group">
						<label>Days:</label>
						<select name="days" class="form-control">
							<option value="">Select Days</option>
							<option value="0">Monday to Friday</option>
							<option value="1">Monday to Saturday</option>
							<option value="2">Monday to Sunday</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="submit-schedule">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Schedule</h5>
			</div>
			<form id="edit_schedule_form" method="POST" action="{{ url('schedule/update') }}">
				@csrf
				<div class="modal-body">
					<input type="hidden" name="id" id="schedule_id">
					<div class="form-group">
						<label>Schedule Name:</label>
						<input type="text" name="name" class="form-control">
					</div>
					<div class="form-group">
						<label>Start Time:</label>
						<input type="text"  name="start" class="schedule-time form-control">
					</div>
					<div class="form-group">
						<label>End Time:</label>
						<input type="text" name="end" class="schedule-time form-control">
					</div>
					<div class="form-group">
						<label>Days:</label>
						<select name="days" class="form-control">
							<option value="">Select Days</option>
							<option value="0">Monday to Friday</option>
							<option value="1">Monday to Saturday</option>
							<option value="2">Monday to Sunday</option>
						</select>
					</div>
					
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit">Save</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection