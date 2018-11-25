@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Leave</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Leave Application</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>Apply for Leave</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<div class="row">
					<div class="col-md-6" style="float: none;display: block;margin: auto;">
						{{ Form::open(['class' => 'form-horizontal form-label-left','files' => true, 'url' => 'leave/insert', 'autocomplete' => 'off','id' => 'leave_application_form'])}}
							@if ($errors->any())

								<div class="form-group">
									<div class="col-md-offset-3 col-md-9 col-sm-4 col-xs-12">
										 <div class="alert alert-danger">
											<ul>
												@foreach($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>	
										</div>
									</div>
								</div>

							@endif
							<fieldset {{ !$leave_types ? "disabled" : ""}}>
							<input autocomplete="false" name="hidden" type="text" style="display:none;">

						 	<div class="col-md-12 text-right">
						 		@if ($leave_types)
							 	<button data-toggle="modal" data-target="#leave-balance" class="btn-link" type="button">My Leave Balance</button>
							 	 @endif
						 	</div>
							@if (session()->has('success')) 
						 		<div class="form-group">
									<div class="col-md-offset-3 col-md-9 col-sm-4 col-xs-12">
										 <span class="text-success"><b>Success!</b> {{ session()->get('success') }}</span>
									</div>
								</div>
						 	@endif
						  	@if (!$leave_types) 
						 		<div class="form-group">
									<div class="col-md-offset-3 col-md-9 col-sm-4 col-xs-12">
										 <span class="text-danger">Cannot request for a leave. No leave allocated.</span>
									</div>
								</div>
						 	@endif
					 		
					 			<div class="form-group" id="a-error" style="display: none;">
									<div class="col-md-offset-3 col-md-9 col-sm-4 col-xs-12">
										 <span class="text-danger"><b>Error!</b> <span class="message"></span> </span>
									</div>
								</div>

								<div class="form-group" id="a-success" style="display: none;">
									<div class="col-md-offset-3 col-md-9 col-sm-4 col-xs-12">
										 <span class="text-success"><span class="message"></span> </span>
									</div>
								</div>
							  	<input type="hidden" name="department_id" value="{{ $department_id }}" required>
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Type of Leave:
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<select class="form-control" name="leave_type" id="leave_type" required="required" data-parsley-errors-container="#error-1">

											<option value="">Select leave type</option>
											@foreach ($leave_types as $leave_type)
												<option value="{{ $leave_type['id'] }}">
												 {{ ucfirst($leave_type['name']) }}
												 </option>
											@endforeach
										</select>
										<span id="error-1"></span>
									</div>	
									 
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">Duration</label>
									<div class="col-md-9">
										<select name="duration" required="required" id="duration" class="form-control">
											<option value="">Select Duration</option>
											<option value="short">Short</option>
											<option value="whole_day">Whole Day</option>
											<option value="long">Long</option>
										</select>
									</div>
								</div>
								<div id="short" style="display: none;">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Date:
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<div class="input-group">
												<input type='text' placeholder="Date" class="form-control" id="short_leave_date" name="leave_date"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
											<span id="error-3"></span>
										</div>	 
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;
										</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="input-group">
												<input type='text' placeholder="Start time" class="form-control" id='start_time' name="start_time"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
											<span id="error-2"></span>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="input-group">
												<input type='text' placeholder="End time" class="form-control" id='end_time' name="end_time"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
											<span id="error-2"></span>
										</div>	 
									</div>

									
								</div>
								<div id="whole_day" style="display: none;">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Date:
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<div class="input-group">
												<input type='text' placeholder="Date" class="form-control" id='whole_day_leave' name="date"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
											<span id="error-2"></span>
										</div>	 
									</div>
	 
								</div>
								<div id="long" style="display: none;">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date:
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<div class="input-group">
												<input type='text' placeholder="Start date" class="form-control" id='start_date' name="start_date"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
											<span id="error-2"></span>
										</div>	 
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">End Date:
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<div class="input-group">
												<input type='text' placeholder="End date" class="form-control" id='end_date' name="end_date"/>
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
											<span id="error-3"></span>
										</div>	 
									</div>
									<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="days">Days:
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<input type='text' class="form-control" placeholder="Days" id='days' name="days" readonly="readonly" />
									</div>	 
								</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12"> Document: 
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<span class="form-control" onclick="document.getElementById('resume').click();"> <span id="r-holder">ex. medical certificate</span>
												<input type="file" style="opacity: 0;" name="document" id="resume" placeholder="Upload image">
										</span>	
									</div>
									 
								</div>

								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Reason: 
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<textarea placeholder="Reason" required="required" class="form-control" name="reason" id="reason" rows="5" data-parsley-errors-container="#error-5"></textarea>
										<span id="error-5"></span>	
									</div>
									 
								</div>

								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp; 
									</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<button type="submit" class="btn btn-success">Submit</button>
									</div>	 
								</div>
					 		</fieldset>

							 

						{{ Form::close()}}
					</div>
					 
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="leave-balance">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-info-circle"></i> My Leave Balance</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
			<tr>
				<th class="text-center" >Type</th>
				<th class="text-center">Allowance Per School Year</th>
				<th class="text-center">Used</th>
				<th class="text-center">Balance</th>
			</tr>
		 	@if ($leave_types)
				@foreach($leave_types as $l)
				<tr>
					<td class="text-center">{{$l['name']}}</td>
					<td class="text-center">{{$l['allowance']}} Days</td>
					<td class="text-center">{{ $l['used'] }}</td>
					<td class="text-center">{{ $l['balance'] }}</td>
				</tr>
				@endforeach
			@else
				<tr>
					<td class="text-center" colspan="4">No leave allocated for you department</td>
				</tr>
			@endif
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div> 
  </div> 
</div> 
<script type="text/javascript">
	var balance = "{{ json_encode($leave_types) }}";
</script>
@endsection