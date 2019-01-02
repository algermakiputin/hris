@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Add Employee</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">New Employee</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>Step 1: <small>Personal Details</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				{{ Form::open(['url' => 'employee/insert', 'files' => true, 'method' => 'POST', 'class' => 'form-horizontal form-left-label', 'autocomplete' => 'off', 'id' => 'new_employee_form'])}}
				@csrf
				@if(session()->has('message'))
				<div>
					<div class="alert alert-success text-center">
						{{ session()->get('message') }} <a href="#">View Departments</a>
					</div>
				</div>
				@endif
				@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				@if (session()->has('success')) 
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4 col-sm-4 col-xs-12">
						<span class="text-success"><b>Success!</b> {{ session()->get('success') }}</span>
					</div>
				</div>
				@endif
				<fieldset class="form-step active" step-no = '1'>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first_name">Full Name  
						</label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="first_name" class="form-control form-control-lg" name="first_name" placeholder="First Name" required="required" data-parsley-group='block1' minlength="2">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="family_name"  class="form-control" name="family_name" placeholder="Family Name" required="required" data-parsley-group='block1' minlength="2">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="middle_initial"  class="form-control" name="middle_initial" placeholder="Middle Initial" required="required" data-parsley-group='block1' minlength="2">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Address  
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" id="street_address" class="form-control" placeholder="Street Address" name="street_address" required="required" data-parsley-group='block1' minlength="6">
						</div>
					</div>
					<div class="form-group">
						<label for="city" class="control-label col-md-2 col-sm-2 col-xs-12">&nbsp;</label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="city"  class="form-control" name="city" placeholder="City" required="required" data-parsley-group='block1' minlength="2">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="state" class="form-control col-md-7 col-xs-12" name="state" placeholder="State" required="required" data-parsley-group='block1' minlength="2">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="zipcode"  class="form-control " name="zipcode" placeholder="Zip Code" required="required" data-parsley-group='block1' minlength="2" data-parsley-type='integer'>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Gender</label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<div id="gender" class="btn-group" data-toggle="buttons">
								<label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
									<input type="radio" name="gender" value="1" checked="checked"> &nbsp; Male &nbsp;
								</label>
								<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
									<input type="radio" name="gender" value="0" > Female
								</label>
							</div>
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12">Birthday</label>
						<div class="col-md-2 col-sm-3 col-xs-12">
							
							<div class="form-group">
								<input type='text' class="form-control birthday" name="birthday" id="birthday" placeholder="YYYY-MM-DD" required="required" data-parsley-group='block1'/>
							</div>
						</div>

						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="number" id="age" class="form-control col-md-7 col-xs-12" name="age" placeholder="Age" readonly="readonly">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">
							Contact
						</label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="email" id="email" class="form-control col-md-7 col-xs-12" name="email_address" placeholder="Email Address" required="required" data-parsley-group='block1'>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="mobile" class="mobile form-control col-md-7 col-xs-12" name="mobile" placeholder="Mobile" required="required" data-parsley-group='block1'>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<input type="text" id="telephone" class="telephone form-control col-md-7 col-xs-12" name="telephone" placeholder="Telephone" data-parsley-group='block1'>
						</div>
					</div>
					<div class="form-group">

						<label class="control-label col-md-2 col-sm-2 col-xs-12">
							Marital Status
						</label>
						<div class="col-md-3 col-sm-3 col-xs-12">
							
							<select name="marital_status" id="marital_status" class="form-control selectpicker" required="required" data-parsley-group='block1'  data-parsley-errors-container="#m-status-error">
								<option value="">Select Status</option>
								<option value="single">Single</option>
								<option value="married">Married</option>
								<option value="divorce">Divorced</option>
								<option value="widowed">Widowed</option>
							</select>
							<div class="clearfix"></div>
							<div id="m-status-error"></div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							
							<select name="education" id="education" class="form-control selectpicker" required="required" data-parsley-group='block1' data-parsley-errors-container="#e-status-error">
								<option value="">Select Education Level</option>
								<option value="Associate Degree">Associate Degree</option>
								<option value="Bachelor Degree">Bachelor's Degree</option>
								<option value="Master Degree">Master's Degree</option>
								<option value="Doctoral Degree">Doctoral Degree</option>
							</select>
							<div class="clearfix"></div>
							<div id="e-status-error"></div>
						</div>
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2 text-right">
							<button type="submit" class="btn btn-success next">Next</button>
						</div>
					</div>
				</fieldset>

				<fieldset class="form-step" step-no = '2'>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Campus Assign</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select name="campus" class="form-control selectpicker" data-parsley-group='block2' required="required" id="select_role_campus" data-parsley-errors-container="#campus-error">
								<option value="">Select Campus</option>
								@foreach ($campuses as $campus)
								<option value="{{ $campus->id }}">{{$campus->name}}</option>
								@endforeach
							</select>
							<div class="clearfix"></div>
							<div id="campus-error"></div>
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12">Department  
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select name="department" class="form-control selectpicker campus-department-select" id="campus-department-select" data-parsley-group='block2' required="required" data-parsley-errors-container="#department-error">
								<option value="">Campus Required</option>
							</select>
							<div class="clearfix"></div>
							<div id="department-error"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Employee ID  
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" name="employee_id" class="form-control col-md-7 col-xs-12" placeholder="Employee ID" data-parsley-group='block2' required="required">
						</div>
						
						<label class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Role  
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12"> 
							<select class="form-control selectpicker" data-parsley-errors-container="#role-error" data-size="5" name="designation">
								<option value="">Select Role</option>
								@foreach ($roles as $role)
								<option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
								@endforeach
							</select>
							<div class="clearfix"></div>
							<div id="role-error"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Date Joining</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="input-group">
								<input type='text' class="form-control" id='date_joining_datepicker' name="date_joining" placeholder="Select Date" data-parsley-group='block2' required="required"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
						
						<label class="control-label col-md-1 col-sm-1 col-xs-12">Status</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select class="form-control selectpicker" data-parsley-errors-container="#status-error" name="status" required="required">
								<option value="">Select Status</option>
								<option value="1">Active</option>
								<option value="0">In Active</option>
							</select>
							<div class="clearfix"></div>
							<div id="status-error"></div>
						</div>

					</div>
					
					<div class="form-group">
						<label for="employment_type" class="control-label col-md-2 col-sm-2 col-xs-12">Employment Type</label>
						<div class="col-md-4 col-sm-4 col-xs-12" >
							<select id="select_employment_type" name="employment_type" class="form-control selectpicker" data-parsley-group='block2' required="required" data-parsley-errors-container="#employment_type-error">
								<option value="">Select Employment Type</option>
								<option value="1">Full Time</option>
								<option value="0">Part Time</option>
							</select>
							<div class="clearfix"></div>
							<div id="employment_type-error"></div>
						</div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12">Salary</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input id="salary" class="form-control salary col-md-7 col-xs-12" type="text" name="salary" placeholder="Salary" data-parsley-group='block2' required="required">
						</div>
					</div>
					<div class="form-group">
						
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Permanent</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select class="form-control" name="tenure">
								<option value="">Permanent Position</option>
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</div>
						<div style="display: none;" id="sched-wrap">
							
							<label class="control-label col-md-1 col-sm-1 col-xs-12">Schedule</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select class="form-control selectpicker" name="schedule" data-parsley-errors-container="#schedule-error">
									<option value="">Select Schedule</option>
									@foreach ($schedules as $schedule)
									<option value="{{ $schedule['id'] }}">{{ $schedule['name'] }}: {{ toTime($schedule['start']) . ' - ' .  toTime($schedule['end']) }}  ( {{ config('config.scheduleDays')[0] }} )</option>
									@endforeach
								</select>
								<div class="clearfix"></div>
								<div id="schedule-error"></div>
							</div>

						</div>
					</div>
					<div class="clearfix"></div>
				     <div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2 text-right">
						<button class="btn btn-primary prev" >Previous</button>
						<button type="submit" class="btn btn-success next">Next</button>
					</div>
				</div>

				
			</fieldset>

			<fieldset class="form-step" step-no = '3'>
				<p>Select file and click submit to complete employee registration.</p>
				<div class="file-upload">
					<div class="form-group" id="resume-wrapper">
						<div class="input-group input-file" name="resume">
							<input type="text" class="form-control" placeholder='Choose a file...' />
							<span class="input-group-btn">
								<button class="btn btn-default btn-choose" type="button">Choose</button>
							</span>
						</div>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-9 col-sm-9	 col-xs-12 col-md-offset-2 text-right">
						<button class="btn btn-primary prev">Previous</button>
						<input type="submit" class="btn btn-success"> 
					</div>
				</div>
			</fieldset>

			<fieldset class="form-step" step-no = '4'>
				<div class="success-page text-center">
                    <span>Employee Added Successfully</span>
				</div>
			</fieldset>
			{{ Form::close() }}
		</div>
	</div>
</div>
</div>
@endsection