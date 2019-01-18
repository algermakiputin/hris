@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Attendance</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Import Attendance</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Import Attendance</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
		 
				<div class="col-md-offset-4 col-md-4">
					{{ Form::open(['url' => 'attendance/file_upload', 'files' => true, 'method' => 'POST','id' => 'attendance_upload_form'])}}
					@csrf
					<p>Select campus and choose files ex(.xls .csv) files</p>
				 	<div class="form-group">
				 		<select class="form-control" name="campus_id" required="required">
				 			<option value="">Select Campus</option>
				 			@foreach ($campuses as $campus)
				 			<option value="{{ $campus->id }}">{{ $campus->name }}</option>
				 			@endforeach
				 		</select>
				 	</div>
					<div class="form-group">
						<span class="form-control" onclick="document.getElementById('attendance').click();"> <span id="p-holder">Choose files</span>
						  <input required="required" type="file" style="opacity: 0;" name="attendance" id="attendance" placeholder="Upload File" data-parsley-errors-container="#error-wrap">

					 	 </span>
						<div id="error-wrap"></div>
						@if ($errors->has('avatar'))
							{{ Session()->get('test') }}
							<span class="invalid-feedback text-danger">{{  $errors->first('avatar') }}</span>
						@endif
						<div class="clearfix"></div>
					</div>

					<div class="form-group">
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
			
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
 
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-confirmation">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title text-danger" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Warning</h4>
			</div>
			<div class="modal-body">
				<h5>Are you sure you want to permanently delete that department?</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger btn-sm" id="yes">Yes</button>
			</div>

		</div>
	</div>
</div>
@endsection