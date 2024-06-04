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
			<input type="text" class="form-control" placeholder="First Name" name="first_name" pattern="[a-zA-Z0-9\s]+" value="{{ $employee->first_name }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Last Name:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Last Name" name="last_name" pattern="[a-zA-Z0-9\s]+" value="{{ $employee->last_name }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Middle Name:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Middle Name" name="middle_name" pattern="[a-zA-Z0-9\s]+" value="{{ $employee->middle_name }}">
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
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Citizenship:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Citizenship" name="citizenship" value="{{ $employee->citizenship }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Religious Affiliation:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="text" class="form-control" placeholder="Religious Affiliation" name="religiousAffiliation" value="{{ $employee->religiousAffiliation }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Height (cm):</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="number" class="form-control" placeholder="Height" name="height" max="200" value="{{ $employee->height }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Weight (kg):</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="number" class="form-control" placeholder="Weight" name="weight" max="200" value="{{ $employee->weight }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Blood Type:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<select type="text" class="form-control" name="bloodType" value="{{ $employee->bloodType }}">
				<option hidden>{{ $employee->bloodType }}</option>
				<option>A+</option>
				<option>A-</option>
				<option>B+</option>
				<option>B-</option>
				<option>AB+</option>
				<option>AB-</option>
				<option>O+</option>
				<option>O-</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Tin No:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="number" class="form-control" placeholder="Tin No." name="tin" value="{{ $employee->tin }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">SSS No.:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="numer" class="form-control" placeholder="SSS No." name="sss" value="{{ $employee->sss }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-2 col-xs-12">Philhealth:</label>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<input type="numer" class="form-control" placeholder="Philhealth" name="philhealth" value="{{ $employee->philhealth }}">
		</div>
	</div>
	<div class="ln_solid"></div>
	<div class="form-group">
		<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
			<button type="submit" class="btn btn-success">Update</button>
		</div>
	</div>
</form>
<div>
	<br/>
    <div class="card">
        <div class="card-header"><b>Family Background</b></div>
        <div class="card-body">
            <form action="{{ url('familyBackground/store') }}" method="POST">
                @csrf
                @method('post')
                <input type="hidden" value="{{ $employee->id }}" name="id" />
                <label style="display:block; background-color:#333;color:#fff;padding:10px;margin: 10px 0;border-radius:5px">Spouse</label>
				<div class="form-group">
					<label>Fisrt Name</label>
					<input type="text" value="{{ isset($familyBackground->spouseFname) ? $familyBackground->spouseFname : '' }}" class="form-control" name="spouse-fname" />
				</div>
				<div class="form-group">
					<label>Last Name</label>
					<input type="text" value="{{ isset($familyBackground->spouseLname) ? $familyBackground->spouseLname : '' }}" class="form-control" name="spouse-lname" />
				</div>
				<div class="form-group">
					<label>Middle Name</label>
					<input type="text" class="form-control" name="spouse-mname" value="{{ isset($familyBackground->spouseMname) ? $familyBackground->spouseMname : '' }}" />
				</div>
				<div class="form-group">
					<label>Occupation</label>
					<input type="text" class="form-control" name="spouse-occupation" value="{{ isset($familyBackground->spouseOccupation) ? $familyBackground->spouseOccupation : '' }}" />
				</div>
				<div class="form-group">
					<label>Employer/Busness Name</label>
					<input type="text" class="form-control" name="spouse-employer" value="{{ isset($familyBackground->spouseEmployer) ? $familyBackground->spouseEmployer : '' }}"/>
				</div>
				<div class="form-group">
					<label>Employer/Bus.Tel.No.</label>
					<input type="text" class="form-control" name="spouse-employer-contact" value="{{ isset($familyBackground->spouseEmployerContact) ? $familyBackground->spouseEmployerContact : '' }}"/>
				</div>
				<div class="form-group">
					<label>Contact No.</label>
					<input type="text" class="form-control" name="spouse-contact" value="{{ isset($familyBackground->spouseContact) ? $familyBackground->spouseContact : '' }}"/>
				</div>
				<label style="display:block; background-color:#333;color:#fff;padding:10px;margin: 10px 0;border-radius:5px">Child/Children</label>
				<table class="table" id="child-table">
					<thead>
						<tr>
							<th>Name of Child</th>
							<th>Date of Birth</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($familyBackground->childNames)): ?>
							<?php foreach($familyBackground->childNames as $key=>$child): ?>
							<tr>
								<td><input type="text" value="{{ $child }}" class="form-control" name="child-name[]" /></td>
								<td><input type="text" value="{{ $familyBackground->childDob[$key] }}" class="form-control" name="child-dob[]" /></td>
								<td><button type="button" class="btn btn-danger child-remove">Remove</button></td>
							</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
				<button type="button" class="btn btn-success" id="add-child">Add Child</button>
				<label style="display:block; background-color:#333;color:#fff;padding:10px;margin: 10px 0;border-radius:5px">Father</label>
				<div class="form-group">
					<label>Last Name</label>
					<input type="text" class="form-control" value="{{ isset($familyBackground->fatherLname) ? $familyBackground->fatherLname : '' }}" name="father-lname"/>
				</div>
				<div class="form-group">
					<label>First Name</label>
					<input type="text" class="form-control" name="father-fname" value="{{ isset($familyBackground->fatherFname) ? $familyBackground->fatherFname : '' }}"/>
				</div>
				<div class="form-group">
					<label>Middle Name</label>
					<input type="text" class="form-control" name="father-mname" value="{{ isset($familyBackground->fatherMname) ? $familyBackground->fatherMname : '' }}"/>
				</div>
				<label style="display:block; background-color:#333;color:#fff;padding:10px;margin: 10px 0;border-radius:5px">Mother</label>
				<div class="form-group">
					<label>Last Name</label>
					<input type="text" class="form-control" name="mother-lname" value="{{ isset($familyBackground->motherLname) ? $familyBackground->motherLname : '' }}"/>
				</div>
				<div class="form-group">
					<label>First Name</label>
					<input type="text" class="form-control" name="mother-fname" value="{{ isset($familyBackground->motherFname) ? $familyBackground->motherFname : '' }}"/>
				</div>
				<div class="form-group">
					<label>Middle Name</label>
					<input type="text" class="form-control" name="mother-mname" value="{{ isset($familyBackground->motherMname) ? $familyBackground->motherMname : '' }}"/>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Update Family Background" />
				</div>
            </form>
        </div>
    </div>
</div>
