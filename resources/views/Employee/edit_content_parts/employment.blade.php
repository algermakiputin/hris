<form class="form-horizontal form-label-left input_mask" method="POST" action="{{ url('employee/update-employment') }}">
	<fieldset {{ Auth()->user()->role == "staff" ? 'disabled' : '' }}>
		@csrf
		@method('patch')
		@if (Session()->get('update') == "employment")
		<div class="form-group">
			<div class="col-md-offset-2 col-sm-9 col-xs-12">
				<span class="text-success"><b>Success!</b> Employment details has been updated successfully</span>
			</div>
		</div>
		@endif
		@if (Session()->get('error'))
		<div class="form-group">
			<div class="col-xs-12">
				<span class="text-danger">{{ Session()->get('error') }}</span>
			</div>
		</div>
		@endif
	 

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Employee ID:</label>
			<input type="hidden" name="id" value="{{ $employee->id }}">
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input type="text" name="_id" value="{{ $employee->employee_id }}" class="form-control"
				data-parsley-remote="{{ url('employee/validate/id') }}"
				data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }'
				data-parsley-remote-message="Employee ID already used"
				>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Campus:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select class="form-control" name="campus_id" id="select_role_campus">
					<option value="">Select Campus</option>
					@foreach ($campuses as $campus)
					<option value="{{ $campus->id }}" {{ $employee->campus_id == $campus->id ? 'selected' : '' }}>{{ ucfirst($campus->name) }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<input type="hidden" name="current_campus" value="{{ $employee->campus_id }}">
		<input type="hidden" name="current_employee_id" value="{{ $employee->employee_id }}">
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Department:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select id="campus-department-select" name="department" class="form-control" data-parsley-group='block2' required="required">
					<option value="">Select Department</option>
					@foreach( $departments as $department )
					<option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
						{{ ucwords($department->name) }}
					</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Designation:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select name="designation" class="form-control">
					<option value="">Select Designation</option>
					@foreach ($roles as $role)
					<option {{ $role->id == $employee->role_id ? 'selected' : ''}} value="{{ $role->id }}">
						{{ ucwords($role->name) }}
					</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Employment Type:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select id="select_employment_type" name="employment_type" class="form-control" data-parsley-group='block2' required="required">
					<option value="">Select Employment Type</option>
					<option value="1" {{ $employee->employment_type == 1 ? 'selected' : '' }}>Full Time</option>
					<option value="0" {{ $employee->employment_type == 0 ? 'selected' : '' }}>Part Time</option>
				</select>
			</div>
		</div>
	 
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Salary ({{ config('config.currency')}}):</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input type="text" class="form-control" value="{{ $employee->salary }}" name="salary">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Date Joining:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="input-group">
					<input type='text' class="form-control" id='date_joining_datepicker' name="date_joining" placeholder="Select Date" data-parsley-group='block2' required="required" value="{{ $employee->date_joining }}" />
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Status:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select name="status" class="form-control" data-parsley-group='block2' required="required">
					<option value="1" {{ $employee->status ? 'selected' : '' }}>Active</option>
					<option value="0" {{ !$employee->status ? 'selected' : '' }}>In Active</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">Tenure:</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<select class="form-control" name="tenure" required="required">
                    	<option value="">Select Tenure</option>
                    	<option value="0" {{ $employee->tenure == 0 ? 'selected' : '' }}>No</option>
                    	<option value="1" {{ $employee->tenure == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
			</div>
		</div>
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
	</fieldset>
</form>