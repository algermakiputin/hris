@extends('master')

@section('main')

<div class="page-title">
	<div class="title_left">
		<h3>Reports</h3>
	</div>
	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Attendance Report</li>
			</ol>
		</nav>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-5">
						<h2>Employee Attendance</h2>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content relative">
				<div class="row">
					<div class="col-md-5">
						<div>
							<select id="employee_id" name="employee_id" data-campusid="" class="form-control selectpicker show-tick" data-size="5" data-live-search="true">
								<option value="" id="select_employee">Select Employee</option>
								@foreach ($employees as $employee) 
								<option data-campusid="{{ $employee->campus_id }}" value="{{ $employee->employee_id }}">{{ ucwords($employee->first_name) . ' ' . ucfirst($employee->last_name) }}</option>
								@endforeach
							</select> &nbsp;

						</div>
					</div>
					<div class="col-md-5">
						<div id="reportrange" class="form-control">
							<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
							<span>December 30, 2014 - January 28, 2015</span>
							<b class="caret"></b>
						</div>
					</div>
					<div class="col-md-2">
						<a target="__blank" href="{{ url('attendance/export') }}" class="btn btn-default" id="export-attendance"><i class="fa fa-file-excel-o"></i> Export Reports</a> 
					</div>
				</div>
			 	<div style="padding: 5px 0;">
			 		<button class="btn btn-default btn-sm"><i class="fa fa-calendar"></i> View Schedule</button>
			 		<button class="btn btn-default btn-sm"><i class="fa fa-calendar"></i> Profile</button>
			 		<button class="btn btn-default btn-sm"><i class="fa fa-calendar"></i> Edit</button>
			 	</div>
				<ul class="stats-overview" style="display: none;">
					<li>
						<span class="name"> Working Days </span>
						<span class="value text-success" id="working">  </span>
					</li>
					<li>
						<span class="name"> Worked </span>
						<span class="value text-success" id="worked">  </span>
					</li>
					<li class="hidden-phone">
						<span class="name"> Total Hours </span>
						<span class="value text-success" id="total_hours">  </span>
					</li>
					<li class="hidden-phone">
						<span class="name"> Absent </span>
						<span class="value text-success" id="absent">  </span>
					</li>
					<li class="hidden-phone">
						<span class="name"> Total Late </span>
						<span class="value text-success" id="total_Late">  </span>
					</li>
					<li class="hidden-phone">
						<span class="name"> Overtime </span>
						<span class="value text-success" id="overtime">  </span>
					</li>

				</ul>
				 
				<!-- <div class="row top_tiles attendance-header">
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">
						<div class="tile-stats"> 
							<h3>Name</h3>
							<p id="name">--</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">
						<div class="tile-stats"> 
							<h3>Employment Type</h3>
							<p id="employmentType">--</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12" id="working-wrapper">
						<div class="tile-stats"> 
							<h3>Working Days</h3>
							<p id="working">--</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12" id="worked-wrapper">
						<div class="tile-stats"> 
							<h3>Total Late</h3>
							<p id="worked">--</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">
						<div class="tile-stats"> 
							<h3>Total Hours</h3>
							<p id="total_hours">--</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12" id="absent-wrapper">
						<div class="tile-stats"> 
							<h3>Absent</h3>
							<p id="absent">--</p>
						</div>
					</div>
					<div class="animated flipInY col-md-offset-3 col-lg-2 col-md-2 col-sm-6 col-xs-12" id="absent-wrapper">
						<div class="tile-stats"> 
							<h3>Schedule</h3>
							<p id="absent">--</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12" id="absent-wrapper">
						<div class="tile-stats"> 
							<h3>Worked</h3>
							<p id="absent">--</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12" id="absent-wrapper">
						<div class="tile-stats"> 
							<h3>Overtime</h3>
							<p id="absent">--</p>
						</div>
					</div>
					 
				 
				</div> -->

				<table class="table table-striped table-bordered no-footer" id="employee_attendance_table">
					<thead>
						<th width="15%">Date</th>
						<th width="15%">Time-In</th>
						<th width="15%">Time-Out</th>
						<th width="15%">Working Hours</th>
						<th width="15%">Late</th>
						<th width="15%">Overtime</th> 
						<th width="10%">Status</th>
					</thead>
					<tbody>
						<tr>
							<td colspan="8" style="text-align:center">Select employee and date range to run reports.</td>
						</tr>
					</tbody>
				</table>
				<div class="process-loader" style="display: none;">Processing</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
@endsection