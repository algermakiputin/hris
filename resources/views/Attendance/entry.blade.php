@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Attendance</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Attendance Manual Entry</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>Manual Entry</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<form class="form-horizontal form-label-left" method="POST" action="{{ url('attendance/insert') }}" id="new_department_form">
					@csrf 
					@if (session()->has('success')) 
				 		<div class="form-group">
							<div class="col-md-offset-4 col-md-4 col-sm-4 col-xs-12">
								 <span class="text-success"><b>Success!</b> {{ session()->get('success') }}</span>
							</div>
						</div>
				 	@endif
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Campus: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select name="campus" class="form-control" id="campus-select">
								<option value="">Select Campus</option>
								@foreach($campuses as $campus)
								<option value="{{ $campus->id }}">{{ ucwords($campus->name) }}</option>
								@endforeach
							</select>
							
						</div>	 
					</div>
				 	
				 	<div class="form-group" style="display: none;" id="employee-wrapper">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Employee: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select name="employee" class="form-control" id="employees">
							 	<option value="">Select Employee</option>
							</select>
							
						</div>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Date: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" class="attendance-date form-control" name="date" placeholder="Date">
						</div>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Time in: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" class="time form-control" name="timein" placeholder="Time in">
						</div>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Time out: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" class="time form-control" name="timeout" placeholder="Time out">
						</div>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">&nbsp; 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12 text-right">
							<button class="btn btn-success" type="submit">Save</button>
						</div>	 
					</div>
 
				</form>
			</div>
		</div>
	</div>
</div>

@endsection