<div>
    <div class="card">
        <div class="card-header"><b>Work Experience</b> <button class="btn btn-success pull-right" id="add-work-exp-btn">Add</button></div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="work-list-table">
                <thead>
                    <th>From</th>
                    <th>To</th>
                    <th>Position Title</th>
                    <th>Company/Office</th>
                    <th>Monthly Salary</th>
                    <th>Status of Employment</th>
                    <th>Length of Service</th>
                </thead>
                <tbody>
                @if($employee->work)
                    @foreach($employee->work as $work)
                    <tr>
                        <td>{{ $work->from }}</td>
                        <td>{{ $work->to }}</td>
                        <td>{{ $work->title }}</td>
                        <td>{{ $work->company }}</td>
                        <td>{{ $work->salary }}</td>
                        <td>{{ $work->employmentStatus }}</td>
                        <td>{{ $work->service }}</td> 
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
        <div class="card-header"><b>Training Program</b> <button class="btn btn-success pull-right" id="add-training-btn">Add</button></div>
        <div class="card-body">
            <table class="table table-stripped table-hover" id="training-list-table">
                <thead>
                    <th>Title</th>
                    <th>From</th>
                    <th>To</th>
                    <th>No. of Hours</th>
                    <th>Conducted/Sponsored By</th> 
                </thead>
                <tbody>
                @if($employee->training)
                    @foreach($employee->training as $training)
                    <tr>
                        <td>{{ $training->trainingTitle }}</td>
                        <td>{{ $training->trainingFrom }}</td>
                        <td>{{ $training->trainingTo }}</td>
                        <td>{{ $training->trainingHours }}</td>
                        <td>{{ $training->trainingSponsor }}</td> 
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
        <div class="card-header"><b>Other Information</b></div>
        <div class="card-body">
            <form action="{{ url('employeeInfo/store') }}" method="POST">
                @csrf
                @method('post')
                <input type="hidden" value="{{ $employee->id }}" name="id" />
                <table class="table">
                    <tr>
                        <th>Special Skills/Hobbies</th>
                        <th>Non-Academic Distinction/Recognition/Awards</th>
                    </tr>
                    <tr>
                        <td><textarea name="hobbies" rows="6" class="form-control">{{ $employee->hobbies }}</textarea></td>
                        <td><textarea name="awards" rows="6" class="form-control">{{ $employee->awards }}</textarea></td>
                    </tr>
                </table>
                <button class="btn btn-primary">Save Other Information</button>
            </form>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="add-exp-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Work Experience</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('workExp/store') }}" method="POST" id="work-exp-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_exp_data" value="{{ json_encode($employee->work) }}" id="current_exp_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="exp_data" id="exp_data" />
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="from" id="exp-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="to" id="exp-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position Title</label>
                        <input type="text" required class="form-control" name="title" id="exp-title"/>
                    </div>
                    <div class="form-group">
                        <label>Company/Offices</label>
                        <input type="text" required class="form-control" name="company" id="exp-company"/>
                    </div>
                    <div class="form-group">
                        <label>Status of Employment</label>
                        <input type="text" required class="form-control" name="company" id="exp-employmentStatus"/>
                    </div>
                    <div class="form-group">
                        <label>Monthly Salary</label>
                        <input type="text" required class="form-control" name="salary" id="exp-salary"/>
                    </div>
                    <div class="form-group">
                        <label>Length of Service</label>
                        <input type="number" required class="form-control" name="lengthOfService" id="exp-service"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="work-submit-btn">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="update-exp-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Work Experience</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('workExp/store') }}" method="POST" id="update-exp-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_exp_data" value="{{ json_encode($employee->work) }}" id="update_current_exp_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="exp_data" id="update_exp_data" />
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="from" id="update-exp-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="to" id="update-exp-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position Title</label>
                        <input type="text" required class="form-control" name="title" id="update-exp-title"/>
                    </div>
                    <div class="form-group">
                        <label>Company/Offices</label>
                        <input type="text" required class="form-control" name="company" id="update-exp-company"/>
                    </div>
                    <div class="form-group">
                        <label>Status of Employment</label>
                        <input type="text" required class="form-control" name="company" id="update-exp-employmentStatus"/>
                    </div>
                    <div class="form-group">
                        <label>Monthly Salary</label>
                        <input type="text" required class="form-control" name="salary" id="update-exp-salary"/>
                    </div>
                    <div class="form-group">
                        <label>Length of Service</label>
                        <input type="number" required class="form-control" name="lengthOfService" id="update-exp-service"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="work-update-btn">Update</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="add-training-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Training Program</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('trainingProgram/store') }}" method="POST" id="training-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_training_data" value="{{ json_encode($employee->training) }}" id="current_training_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="training_data" id="training_data" />
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="training-from" id="training-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="training-to" id="training-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position Title</label>
                        <input type="text" required class="form-control" name="training-title" id="training-title"/>
                    </div> 
                    <div class="form-group">
                        <label>No. of Hours</label>
                        <input type="text" required class="form-control" name="training-hours" id="training-hours"/>
                    </div>
                    <div class="form-group">
                        <label>Conducted/Sponsored By</label>
                        <input type="text" required class="form-control" name="training-sponsor" id="training-sponsor"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="training-submit-btn">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="update-training-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Training Program</h5> 
			</div>
			<div class="modal-body">
                <form action="{{ url('trainingProgram/store') }}" method="POST" id="update-training-form">
                    @csrf
                    @method('post')
                    <input type="hidden" name="current_training_data" value="{{ json_encode($employee->training) }}" id="update_current_training_data"/>
                    <input type="hidden" name="id" value="{{ $employee->id }}" />
                    <input type="hidden" name="training_data" id="update-training_data" />
                    <div class="form-group">
                        <label>From</label>
                        <input type="date" required class="form-control" name="training-from" id="update-training-from"/>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="date" required class="form-control" name="training-to" id="update-training-to"/>
                    </div>
                    <div class="form-group">
                        <label>Position Title</label>
                        <input type="text" required class="form-control" name="training-title" id="update-training-title"/>
                    </div> 
                    <div class="form-group">
                        <label>No. of Hours</label>
                        <input type="text" required class="form-control" name="training-hours" id="update-training-hours"/>
                    </div>
                    <div class="form-group">
                        <label>Conducted/Sponsored By</label>
                        <input type="text" required class="form-control" name="training-sponsor" id="update-training-sponsor"/>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="training-update-btn">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>