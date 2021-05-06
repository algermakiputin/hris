

@if (Session()->get('update') == "schedule" && !Session()->get('error'))
<div class="form-group">
	<div class="col-xs-12">
		<span class="text-success"><b>Success!</b> {{ Session()->get('success') }}</span>
	</div>
</div>
@endif

@if (Session()->get('error'))
<div class="form-group">
	<div class="col-xs-12">
		<span class="text-danger"><b>Error!</b> complex schedule found</span>
	</div>
</div>
@endif
@csrf
 

 
<table class="table table-striped table-bordered table-hover">
	 
	<tbody>

		@if ($partimeScheds)
		 	@foreach ($partimeScheds as $key => $sched) 
		 		<tr>
		 			<th colspan="4">{{  config('config.weekOfDay')[$key - 1] }}</th>
		 		</tr>
		 		@foreach ($sched as $s)
		 			<tr>
		 				<td colspan="3">{{ date('h:i a', strtotime($s['start'])) }} - {{ date('h:i a', strtotime($s['end']))}}</td> 
		 				<td>
		 					<form method="POST" action="{{ url('parttimeschedule/destroy') }}">
		 						@csrf
		 						<input type="hidden" name="id" value="{{ $s['id'] }}">
		 						<button class="btn btn-sm" type="submit">Delete</button>
		 					</form>
		 				</td>
		 			</tr>
		 		@endforeach
		 	@endforeach 

		@else 
		<p>Empty Schedule</p>

		@endif
	</tbody>
</table>

<hr>
<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#schedule-form"><i class="fa fa-plus"></i> Add Schedule</button>


	<div class="modal" tabindex="-1" role="dialog" id="schedule-form">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form method="POST" action="{{ url('parttimeschedule/insert') }}">
					<div class="modal-header">
						<h5 class="modal-title">Add Schedule</h5> 
					</div>
					<div class="modal-body">
						@csrf
						<input type="hidden" name="campus_id" value="{{ $employee->campus_id }}">
						<input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
						<div class="form-group">
							<label>Select Day</label>
							<select name="day" class="form-control">
								<option value="1">Monday</option>
								<option value="2">Tuesday</option>
								<option value="3">Wednesday</option>
								<option value="4">Thursday</option>
								<option value="5">Friday</option>
								<option value="6">Saturday</option>
								<option value="7">Sunday</option>
							</select>
						</div>

						<div class="form-group">
							<label>Start Time</label>
							<input type="text" placeholder="Time in" name="start_time" class="form-control schedule-time">
						</div>

						<div class="form-group">
							<label>End Time</label>
							<input type="text" placeholder="End in" name="end_time" class="form-control schedule-time">
						</div>

					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>

		</div>
	</div>