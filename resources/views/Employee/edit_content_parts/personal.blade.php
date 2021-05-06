<form class="form-horizontal form-label-left input_mask" method="POST" action="{{ url('employee/update') }}">
	@csrf
	@method('patch')
	@if (session()->has('success-personal'))
	<div class="form-group">
		<div class="col-md-offset-3 col-md-9 col-sm-9 col-xs-12">
			<span class="text-success"><b>Success!</b> {{ session()->get('success-personal') }}</span>
		</div>
	</div>
	@endif
	<input type="hidden" name="_id" value="{{ $employee->id }}">
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">First Name:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ $employee->first_name }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Last Name:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ $employee->last_name }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Middle Name:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Middle Name" name="middle_name" value="{{ $employee->middle_name }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Gender:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div id="gender" class="btn-group" data-toggle="buttons">
				<label class="btn btn-default {{ $employee->gender == 1 ? 'active' : '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
					<input type="radio" name="gender" value="1" {{ $employee->gender == 1 ? 'checked' : '' }}> &nbsp; Male &nbsp;
				</label>
				<label class="btn btn-default {{ $employee->gender == 0 ? 'active' : '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
					<input type="radio" name="gender" value="0" {{ $employee->gender == 0 ? 'checked' : '' }} > Female
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Birthday:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type='text' class="form-control birthday" id='birthday' name="birthday" placeholder="YYYY-MM-DD" required="required" data-parsley-group='block1' value="{{ $employee->birthday }}"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Age:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="number" class="form-control" id="age" placeholder="Age" name="age" value="{{ $age }}" readonly="readonly">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Email:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="email" class="form-control" placeholder="Email" name="email" value="{{ $employee->email_address }}"
			data-parsley-group='block2' required="required"
			data-parsley-remote="{{ url('employee/validate/email') }}"
			data-parsley-remote-options='{ "type": "POST", "dataType": "jsonp", "data": { "_token": "{{ csrf_token() }}" } }'
			data-parsley-remote-message="Email name already used"
			>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Mobile Number:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Mobile Number" name="mobile" value="{{ $employee->mobile }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Telephone:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Telephone" name="telephone" value="{{ $employee->telephone }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Marital Status:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<select name="marital_status" id="marital_status" class="form-control" required="required" data-parsley-group='block1' data-parsley-notequalto="#default" >
				<option value="">Select Status</option>
				<option  {{ $employee->marital_status == 'single' ? 'selected' : ''}} value="single"> Single</option>
				<option {{ $employee->marital_status == 'married' ? 'selected' : ''}} value="married">Married</option>
				<option value="divorce" {{ $employee->marital_status == 'divorce' ? 'selected' : ''}}>Divorced</option>
				<option value="widowed" {{ $employee->marital_status == 'widowed' ? 'selected' : ''}}>Widowed</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Education Level</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<select name="education" id="education" class="form-control selectpicker" required="required" data-parsley-group='block1' data-parsley-notequalto="#default" data-parsley-errors-container="#e-status-error">
			<option value="">Select Education Level</option>
			<option value="Associate Degree" {{ $employee->education == 'Associate Degree' ? 'selected' : '' }}>Associate Degree</option>
			<option value="Bachelor Degree" {{ $employee->education == 'Bachelor Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
			<option value="Master Degree" {{ $employee->education == 'Master Degree' ? 'selected' : '' }}>Master's Degree</option>
			<option value="Doctoral Degree" {{ $employee->education == 'Doctoral Degree' ? 'selected' : '' }}>Doctoral Degree</option>
		</select>
		</div>
	</div>
	<div class="ln_solid"></div>
	<div class="form-group">
		<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
			<button type="submit" class="btn btn-success">Update</button>
		</div>
	</div>
</form>