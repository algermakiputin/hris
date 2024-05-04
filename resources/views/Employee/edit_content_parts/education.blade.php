<div>
    <div class="card">
        <div class="card-header"><b>Educational Background</b></div>
        <div class="card-body">
            <form action="{{ url('educationalBackground/store') }}" method="POST" id="civil-service-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                <table class="table table-stripped table-hover" id="educational-background" width="100%">
                    <thead>
                        <th width="5%">Level</th>
                        <th>School</th>
                        <th>Degree</th>
                        <th>Year Graduated</th>
                        <th>Highes Grade/Level/Units Earned(if not graduated)</th>
                        <th>Inclusive dates of attendance from - to</th>
                        <th>Scholarship/Academic honors received</th> 
                    </thead>
                    <tbody> 
                        
                        <tr>
                            <td>Elementary</td>
                            <td><textarea name="elementary-school" rows="5" class="form-control">{{ isset($elementary->school) ? $elementary->school : '' }}</textarea></td>
                            <td><textarea name="elementary-degree" rows="5" class="form-control hidden">{{ isset($elementary->degree) ? $elementary->degree : ''  }}</textarea></td>
                            <td><textarea name="elementary-year" rows="5" class="form-control">{{ isset($elementary->year) ? $elementary->year : '' }}</textarea></td>
                            <td><textarea name="elementary-highestGrade" rows="5" class="form-control">{{ isset($elementary->highestGrade) ? $elementary->highestGrade : '' }}</textarea></td>
                            <td><textarea name="elementary-inclusiveDates" rows="5" class="form-control">{{ isset($elementary->inclusiveDates) ? $elementary->inclusiveDates : '' }}</textarea></td>
                            <td><textarea name="elementary-scholarship" rows="5" class="form-control">{{ isset($elementary->scholarship) ? $elementary->scholarship : '' }}</textarea></td>
                        </tr>  
                        <tr>
                            <td>Secondary</td>
                            <td><textarea name="secondary-school" rows="5" class="form-control">{{ isset($secondary->school) ? $secondary->school : '' }}</textarea></td>
                            <td><textarea hidden name="secondary-degree" name="" rows="5" class="form-control hidden">{{ isset($secondary->degree) ? $secondary->degree : '' }}</textarea></td>
                            <td><textarea name="secondary-year" rows="5" class="form-control">{{ isset($secondary->year) ? $secondary->year : '' }}</textarea></td>
                            <td><textarea name="secondary-highestGrade" rows="5" class="form-control">{{ isset($secondary->highestGrade) ? $secondary->highestGrade : '' }}</textarea></td>
                            <td><textarea name="secondary-inclusiveDates" rows="5" class="form-control">{{ isset($secondary->inclusiveDates) ? $secondary->inclusiveDates : '' }}</textarea></td>
                            <td><textarea name="secondary-scholarship" rows="5" class="form-control">{{ isset($secondary->scholarship) ? $secondary->scholarship : '' }}</textarea></td>
                        </tr>
                        <tr>
                            <td>Vocational/Trade Course</td>
                            <td><textarea name="vocational-school" rows="5" class="form-control">{{ isset($vocational->school) ? $vocational->school : '' }}</textarea></td>
                            <td><textarea  name="vocational-degree" rows="5" class="form-control hidden">{{ isset($vocational->degree) ? $vocational->degree : '' }}</textarea></td>
                            <td><textarea  name="vocational-year" rows="5" class="form-control">{{ isset($vocational->year) ? $vocational->year : '' }}</textarea></td>
                            <td><textarea  name="vocational-highestGrade" rows="5" class="form-control">{{ isset($vocational->highestGrade) ? $vocational->highestGrade : '' }}</textarea></td>
                            <td><textarea name="vocational-inclusiveDates" rows="5" class="form-control">{{ isset($vocational->inclusiveDates) ? $vocational->inclusiveDates : '' }}</textarea></td>
                            <td><textarea  name="vocational-scholarship" rows="5" class="form-control">{{ isset($vocational->scholarship) ? $vocational->scholarship : '' }}</textarea></td>
                        </tr>
                        <tr>
                            <td>College</td>
                            <td><textarea  name="college-school" rows="5" class="form-control">{{ isset($college->school) ? $college->school : '' }}</textarea></td>
                            <td><textarea name="college-degree" rows="5" class="form-control">{{ isset($college->degree) ? $college->degree : '' }}</textarea></td>
                            <td><textarea name="college-year" rows="5" class="form-control">{{ isset($college->year) ? $college->year : ''  }}</textarea></td>
                            <td><textarea  name="college-highestGrade" rows="5" class="form-control">{{ isset($college->highestGrade) ? $college->highestGrade : '' }}</textarea></td>
                            <td><textarea name="college-inclusiveDates" rows="5" class="form-control">{{ isset($college->inclusiveDates) ? $college->inclusiveDates :'' }}</textarea></td>
                            <td><textarea name="college-scholarship" rows="5" class="form-control">{{ isset($college->scholarship) ? $college->scholarship : '' }}</textarea></td>
                        </tr>
                        <tr>
                            <td>Graduate Studies</td>
                            <td><textarea  name="graduate-school" rows="5" class="form-control">{{ isset($graduate->school) ? $graduate->school : '' }}</textarea></td>
                            <td><textarea  name="graduate-degree" rows="5" class="form-control">{{ isset($college->degree) ? $college->degree : '' }}</textarea></td>
                            <td><textarea   name="graduate-year" rows="5" class="form-control">{{ isset($college->year) ? $college->year : '' }}</textarea></td>
                            <td><textarea  name="graduate-highestGrade" rows="5" class="form-control">{{ isset($college->highestGrade) ? $college->highestGrade : '' }}</textarea></td>
                            <td><textarea  name="graduate-inclusiveDates" rows="5" class="form-control">{{ isset($college->inclusiveDates) ? $college->inclusiveDates : '' }}</textarea></td>
                            <td><textarea  name="graduate-scholarship" rows="5" class="form-control">{{ isset($college->scholarship) ? $college->scholarship : '' }}</textarea></td>
                        </tr>                  
                    </tbody>
                </table>
                <input type="submit" class="btn btn-primary" value="Save"/>
            </form>
        </div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-header"><b>Civil Service Eligiblity</b> <button class="btn btn-success pull-right" id="add-career-service-btn">Add</button></div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="civil-service-table">
                <thead>
                    <th>Career Service</th>
                    <th>Rating</th>
                    <th>Date of Examination</th>
                    <th>Place of Examination</th>
                    <th>Number</th>
                    <th>Date of Release</th> 
                </thead>
                <tbody>
                @if($employee->civil_service)
                    @foreach($employee->civil_service as $civilService)
                    <tr>
                        <td>{{ isset($civilService->careerService) ? $civilService->careerService : '' }}</td>
                        <td>{{ isset($civilService->rating) ? $civilService->rating : '' }}</td>
                        <td>{{ isset($civilService->date) ? $civilService->date :'' }}</td>
                        <td>{{ isset($civilService->place) ? $civilService->place : '' }}</td>
                        <td>{{ isset($civilService->numbe) ? $civilService->numbe : '' }}</td>
                        <td>{{ property_exists($civilService, 'releaseDate') ? $civilService->releaseDate : '' }}</td> 
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="7">No data available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-header"><b>Involvement In Other Educational Or Professional Organization</b> <button class="btn btn-success pull-right" id="add-involvement-btn">Add</button></div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="involvement-list-table">
                <thead>
                    <th>Organization Name</th>
                    <th>Organization Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Position</th> 
                </thead>
                <tbody>
                @if($employee->involvement)
                    @foreach($employee->involvement as $involvement)
                    <tr>
                        <td>{{ isset($involvement->organization) ? $involvement->organization : '' }}</td>
                        <td>{{ isset($involvement->address) ? $involvement->address : '' }}</td>
                        <td>{{ isset($involvement->from) ? $involvement->from : '' }}</td>
                        <td>{{ isset($involvement->to) ? $involvement->to : '' }}</td>
                        <td>{{ isset($involvement->position) ? $involvement->position : '' }}</td> 
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="7">No data available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div> 

<div>
    <div class="card">
        <div class="card-header"><b>Involvement In Other CIVIC (Non Government/People) Voluntary Organization</b> <button class="btn btn-success pull-right" id="add-voluntary-btn">Add</button></div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="voluntary-list-table">
                <thead>
                    <th>Organization Name</th>
                    <th>Organization Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Position</th> 
                </thead>
                <tbody>
                @if($employee->voluntary)
                    @foreach($employee->voluntary as $voluntary)
                    <tr>
                        <td>{{ isset($voluntary->organization) ? $voluntary->organization : '' }}</td>
                        <td>{{ isset($voluntary->address) ? $voluntary->address : '' }}</td>
                        <td>{{ isset($voluntary->from) ? $voluntary->from : '' }}</td>
                        <td>{{ isset($voluntary->to) ? $voluntary->to : '' }}</td>
                        <td>{{ isset($voluntary->position) ? $voluntary->position : '' }}</td> 
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="7">No data available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="add-career-service-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Civil Service Eligiblity</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('career/store') }}" method="POST" id="civil-service-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_civil_service" value="{{ json_encode($employee->civil_service) }}" id="current_civil_service"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="civil_service_data" id="civil_service_data" />
                    <div class="form-group">
                        <label>Career Service / RA 1080 (Board/Bar) Under Special Law CES/CSEE</label>
                        <input type="text" required class="form-control" name="career-service" id="career-service"/>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <input type="text" required class="form-control" name="rating" id="rating"/>
                    </div>
                    <div class="form-group">
                        <label>Date of Examination</label>
                        <input type="date" required class="form-control" name="date" id="date"/>
                    </div>
                    <div class="form-group">
                        <label>Place of Examination</label>
                        <input type="text" required class="form-control" name="place" id="place"/>
                    </div> 
                    <div class="form-group">
                        <label>Number</label>
                        <input type="text" required class="form-control" name="number" id="number"/>
                    </div>
                    <div class="form-group">
                        <label>Date of Release</label>
                        <input type="date" required class="form-control" name="release-date" id="release-date"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="civil-service-submit-btn">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="update-civil-service-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Civil Service</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('career/store') }}" method="POST" id="update-civil-service-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_civil_service" value="{{ json_encode($employee->civil_service) }}" id="update_current_civil_service"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="civil_service_data" id="update_civil_service_data" />
                    <div class="form-group">
                        <label>Career Service / RA 1080 (Board/Bar) Under Special Law CES/CSEE</label>
                        <input type="text" required class="form-control" name="career-service" id="update-career-service"/>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <input type="text" required class="form-control" name="rating" id="update-rating"/>
                    </div>
                    <div class="form-group">
                        <label>Date of Examination</label>
                        <input type="date" required class="form-control" name="date" id="update-date"/>
                    </div>
                    <div class="form-group">
                        <label>Place of Examination</label>
                        <input type="text" required class="form-control" name="place" id="update-place"/>
                    </div> 
                    <div class="form-group">
                        <label>Number</label>
                        <input type="text" required class="form-control" name="number" id="update-number"/>
                    </div>
                    <div class="form-group">
                        <label>Date of Release</label>
                        <input type="date" required class="form-control" name="release-date" id="update-release-date"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="civil-service-update-btn">Update</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="add-involvement-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Involvement Form</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('involvement/store') }}" method="POST" id="involvement-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_involvement_data" value="{{ json_encode($employee->involvement) }}" id="current_involvement_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="involvement_data" id="involvement_data" />
                    <div class="form-group">
                        <label>Organization Name</label>
                        <input type="text" required class="form-control" name="organization" id="organization"/>
                    </div>
                    <div class="form-group">
                        <label>Organization Address</label>
                        <input type="text" required class="form-control" name="address" id="address"/>
                    </div> 
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="involvement-from" id="involvement-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="involvement-to" id="involvement-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" required class="form-control" name="position" id="position"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="involvement-submit-btn">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="update-involvement-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Involvement</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('involvement/store') }}" method="POST" id="update-involvement-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_involvement_data" value="{{ json_encode($employee->involvement) }}" id="update_current_involvement_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="involvement_data" id="update_involvement_data" />
                    <div class="form-group">
                        <label>Organization Name</label>
                        <input type="text" required class="form-control" name="organization" id="update-organization"/>
                    </div>
                    <div class="form-group">
                        <label>Organization Address</label>
                        <input type="text" required class="form-control" name="address" id="update-address"/>
                    </div> 
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="involvement-from" id="update-involvement-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="involvement-to" id="update-involvement-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" required class="form-control" name="position" id="update-position"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="involvement-update-btn">Update</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="add-voluntary-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Voluntary Involvement Form</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('voluntary/store') }}" method="POST" id="voluntary-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_voluntary_data" value="{{ json_encode($employee->voluntary) }}" id="current_voluntary_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="voluntary_data" id="voluntary_data" />
                    <div class="form-group">
                        <label>Organization Name</label>
                        <input type="text" required class="form-control" name="organization" id="voluntary-organization"/>
                    </div>
                    <div class="form-group">
                        <label>Organization Address</label>
                        <input type="text" required class="form-control" name="address" id="voluntary-address"/>
                    </div> 
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="voluntary-from" id="voluntary-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="voluntary-to" id="voluntary-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" required class="form-control" name="position" id="voluntary-position"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="voluntary-submit-btn">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="update-voluntary-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Voluntary Involvement Form</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('voluntary/store') }}" method="POST" id="update-voluntary-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_voluntary_data" value="{{ json_encode($employee->voluntary) }}" id="update_current_voluntary_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="voluntary_data" id="update_voluntary_data" />
                    <div class="form-group">
                        <label>Organization Name</label>
                        <input type="text" required class="form-control" name="organization" id="update-voluntary-organization"/>
                    </div>
                    <div class="form-group">
                        <label>Organization Address</label>
                        <input type="text" required class="form-control" name="address" id="update-voluntary-address"/>
                    </div> 
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="voluntary-from" id="update-voluntary-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="voluntary-to" id="update-voluntary-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" required class="form-control" name="position" id="update-voluntary-position"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" id="update-voluntary-btn">Update</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<style>
    .card {
        padding: 20px;
        border: solid 1px #ddd;
        margin-bottom:20px;
    }
</style>