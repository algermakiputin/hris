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
				<li class="breadcrumb-item active" aria-current="page">Leaves</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>My Appointments</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content"> 
				<table class="table table-striped table-bordered" id="my_appointments_table">
					<thead>
						<tr>
							<th>Campus</th>
							<th>Name</th>
							<th>Department/Office</th>
							<th>Designation</th> 
							<th>Time & Date</th>
							<th>Reason</th>
							<th>Status</th> 
						</tr>
					</thead> 
					<tbody>
						@foreach($appointments as $appointment)
						<tr>
							<td>{{ $campus->name }}</td>
							<td>{{ $employee->first_name . ' ' . $employee->last_name }}</td>
							<td>{{ $department->name }}</td>
							<td>{{ $role->name }}</td> 
							<td>{{ $appointment->date_time }}</td>
							<td>{{ $appointment->reason }}</td>
							<td>{{ $appointment->status }}</td>
						</tr>
						@endforeach
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