@extends('master')

@section('main')

<div class="page-title">
	<div class="title_left">
		<h3>Calendar</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">School Calendar</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-5">
						<h2>Events Calendar</h2>
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content relative">
				<div class="row">
					<div class="col-md-9">
						<div id="holidays" style="z-index: 1"></div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="x_panel" id="event-wrap">
							<div class="x_title">
								<h2>Events <small id="e-month"></small></h2>

								<div class="clearfix"></div>
							</div>
							<div class="x_content">

								<div class="">
									<ul class="to_do" id="event-list">
										<li>
											No event found  
										</li>

									</ul>
								</div>
							</div>
						</div>
						<div class="x_panel" id="holiday-wrap">
							<div class="x_title">
								<h2>Holidays <small id="h-month"></small></h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">

								<div class="">
									<ul class="to_do" id="holiday-list">
										<li>
											No holiday found  
										</li>

									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

</div>

<div class="modal fade" id="holidays-modal">
	<div class="modal-dialog">

		<div class="modal-content">
			<form role="form" id="calendarForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">New Calendar Entry</h4>
				</div>
				<div class="modal-body">
					<div  class="form-horizontal calender" >
						<div class="form-group">
							<label class="col-sm-3 control-label">Type</label>
							<div class="col-sm-9">
								<select name="type" class="form-control" id="type">
									<option value="">Select Type</option>
									<option value="holiday">Holiday</option>
									<option value="event">Event</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Title</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="title" name="title">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Description</label>
							<div class="col-sm-9">
								<textarea class="form-control" style="height:65px;" id="descr" name="descr"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="holidays-view">
	<div class="modal-dialog">

		<div class="modal-content">
			<form role="form" id="updateCalendar">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Event Calendar</h4>
				</div>
				<div class="modal-body">
					<fieldset disabled="disabled" id="edit-field">
						<div  class="form-horizontal calender" >

							<div class="form-group">
								<label class="col-sm-3 control-label">Title</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="title" name="title">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Type</label>
								<div class="col-sm-9">
									<select name="type" class="form-control" id="type">
										<option value="">Select Type</option>
										<option value="holiday">Holiday</option>
										<option value="event">Event</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Description</label>
								<div class="col-sm-9">
									<textarea class="form-control" style="height:65px;" id="descr" name="descr"></textarea>
								</div>
							</div>
						</div>
						<input type="hidden" name="id" id="e_id">
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					@if (Auth()->user()->role)
						<button type="button" class="btn btn-danger" id="delete">Delete</button>
						<button type="button" class="btn btn-success" id="edit">Edit</button>
						<button type="submit" id="update" disabled="disabled" class="btn btn-primary">Save</button>
					@endif
				</div>
			</form>
		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->
</div>
<script>
	var str = "{{ json_encode($events) }}";
	str = str.replace(/&quot;/g,'"');
	var events = (JSON.parse(str)); 
</script>
@endsection