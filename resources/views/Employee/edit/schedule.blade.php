<form class="form-horizontal form-label-left" action="{{ url('parttimeschedule/update') }}" method="POST">

	@if (Session()->get('update') == "schedule")
	<div class="form-group">
		<div class="col-md-offset-2 col-sm-9 col-xs-12">
			<span class="text-success"><b>Success!</b> Schedule has been updated successfully</span>
		</div>
	</div>
	@endif
	@csrf
	<input type="hidden" name="campus_id" value="{{ $employee->campus_id }}">
	<input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
	<input type="hidden" name="set" value="{{ count($partimeScheds) }}">
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Monday:</label>
		<div class="col-md-4">
			<input type="text" placeholder="Time in" name="mon[]" class="form-control schedule-time" value="{{ scheduleExist(1, 'start', $partimeScheds) }}">
		</div>
		<div class="col-md-4">
			<input type="text" placeholder="Time out" name="mon[]" class="form-control schedule-time" value="{{ scheduleExist(1, 'end', $partimeScheds) }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Tuesday:</label>
		<div class="col-md-4">
			<input type="text" placeholder="Time in" name="tue[]" class="form-control schedule-time" value="{{ scheduleExist(2, 'start', $partimeScheds) }}">
		</div>
		<div class="col-md-4">
			<input type="text" placeholder="Time out" name="tue[]" class="form-control schedule-time" value="{{ scheduleExist(2, 'end', $partimeScheds) }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Wednesday:</label>
		<div class="col-md-4">
			<input type="text" placeholder="Time in" name="wed[]" class="form-control schedule-time" value="{{ scheduleExist(3, 'start', $partimeScheds) }}">
		</div>
		<div class="col-md-4">
			<input type="text" placeholder="Time out" name="wed[]" class="form-control schedule-time" value="{{ scheduleExist(3, 'end', $partimeScheds) }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Thursday:</label>
		<div class="col-md-4">
			<input type="text" placeholder="Time in" name="thu[]" class="form-control schedule-time" value="{{ scheduleExist(4, 'start', $partimeScheds) }}">
		</div>
		<div class="col-md-4">
			<input type="text" placeholder="Time out" name="thu[]" class="form-control schedule-time" value="{{ scheduleExist(4, 'end', $partimeScheds) }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Friday:</label>
		<div class="col-md-4">
			<input type="text" placeholder="Time in" name="fri[]" class="form-control schedule-time" value="{{ scheduleExist(5, 'start', $partimeScheds) }}">
		</div>
		<div class="col-md-4">
			<input type="text" placeholder="Time out" name="fri[]" class="form-control schedule-time" value="{{ scheduleExist(5, 'end', $partimeScheds) }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Saturday:</label>
		<div class="col-md-4">
			<input type="text" placeholder="Time in" name="sat[]" class="form-control schedule-time" value="{{ scheduleExist(6, 'start', $partimeScheds) }}">
		</div>
		<div class="col-md-4">
			<input type="text" placeholder="Time out" name="sat[]" class="form-control schedule-time" value="{{ scheduleExist(6, 'end', $partimeScheds) }}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-2 col-sm-3 col-xs-12">Sunday:</label>
		<div class="col-md-4">
			<input type="text" placeholder="Time in" name="sun[]" class="form-control schedule-time" value="{{ scheduleExist(7, 'start', $partimeScheds) }}">
		</div>
		<div class="col-md-4">
			<input type="text" placeholder="Time out" name="sun[]" class="form-control schedule-time" value="{{ scheduleExist(7, 'end', $partimeScheds) }}">
		</div>
	</div>
	<div class="ln_solid"></div>
	<div class="form-group">
		<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
			<button type="submit" class="btn btn-success">Update</button>
		</div>
	</div>
</form>

