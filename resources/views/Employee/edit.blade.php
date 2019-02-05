@extends('master')
@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Edit Employee</h3>
	</div>
	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
			</ol>
		</nav>
	</div>
</div>
<div class="row">
	<div class="row">
		<div class="col-md-8">
			<div class="x_panel">
				<div class="x_title">
					<a href="{{ url('employee') }}"><i class="fa fa-link"></i> Return</a>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="{{ Session()->has('update') == "" ? 'active in' : ''  }}"><a href="#personal" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Personal Details</a>
							</li>
							<li role="presentation" class="{{ Session()->get('update') == "employment" ? 'active in' : ''  }}"><a href="#employment" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Employment Details</a>
							</li>
							<li role="presentation" class="{{ Session()->get('update') == "resume" ? 'active in' : ''  }}" ><a href="#files" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Documents</a>
							</li>
						 	@if (Auth()->user()->role)
							<li role="presentation" class="{{ Session()->get('update') == "schedule" ? 'active in' : ''  }}">
								<a href="#scheds" role="tab" id="sched-tab3" data-toggle="tab" aria-expanded="true">Schedules</a>
							</li>
						 	@endif
						</ul>
						<div id="myTabContent" class="tab-content">
							@if (Auth()->user()->role)
							<div role="tabpanel" class="tab tab-pane fade {{ Session()->get('update') == "schedule" ? 'active in' : ''  }}" id="scheds" aria-labelledby="sched-tab">
								<div class="col-xs-12">
									<div class="x_content">
										<br>
										@include('Employee.edit_content_parts.schedule')
									</div>
								</div> 
							</div>
							@endif
							<div role="tabpanel" class="tab-pane fade {{ Session()->has('update') ? '' : 'active in'  }}" id="personal" aria-labelledby="home-tab">
								<div class=" col-xs-12">
									<div class="x_content">
										<br />
										@include('Employee.edit_content_parts.personal')
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade {{ Session()->get('update') == "employment" ? 'active in' : ''  }}" id="employment" aria-labelledby="profile-tab">
								<div class="col-xs-12">
									<div class="x_content">
										<br>
										@include('Employee.edit_content_parts.employment')
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade {{ Session()->get('update') == "resume" ? 'active in' : ''  }}" id="files" aria-labelledby="profile-tab">
								<br>
								@if (Session()->get('update') == "resume")
								<div class="form-group">
									<div class="col-md-offset-2 col-sm-9 col-xs-12">
										<span class="text-success"><b>Success!</b> Resume has been updated successfully</span>
									</div>
								</div>
								@endif
								<div class="col-md-12">
									<form action="{{ url('employee/resume/update') }}" method="POST" enctype="multipart/form-data">
										@csrf
										@method('patch')
										<input type="hidden" name="id" value="{{ $employee->id }}">
										<input type="hidden" name="old_file" value="{{ $employee->resume }}">
										<div class="form-group">
											<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
												Uploaded Resume File: <a href="{{ url('storage/resume') . '/' .  $employee->resume }}">{{ $employee->resume }}</a>
												<br>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">Update Resume</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<span class="form-control" onclick="document.getElementById('resume').click();"> <span id="r-holder">Choose files..</span>
												<input type="file" style="opacity: 0;" name="resume" id="resume" placeholder="Upload image">
											</span>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
											<button type="submit" class="btn btn-success">Upload</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="x_panel">
			<div class="x_content">
				<form class="form-horizontal form-label-left input_mask" method="POST" action="{{ url('employee/upload-avatar') }}" enctype="multipart/form-data">
					<fieldset>
						@csrf
						@if (session()->has('success-upload'))
						<div class="form-group">
							<div class="col-md-offset-1 col-md-11 col-sm-9 col-xs-12">
								<span class="text-success"><b>Success!</b> {{ session()->get('success-upload') }}</span>
							</div>
						</div>
						@endif
						<input type="hidden" name="_id" value="{{ $employee->employee_id }}">
						<input type="hidden" name="old_img" value="{{ $employee->avatar  }}">
						<div class="form-group" id="img-container" {{ $employee->avatar ? '' : 'style="display:none"' }}>
							<div id="crop-avatar" class="text-center" style="margin: auto 0;">
								@if ($employee->avatar)
								<img src="{{ asset('storage/avatar' . '/' . $employee->avatar) }}" id="img" >
								@else
								<img src="{{ url('images/default.png')}}" alt="..." class=" profile_img">
								@endif
							</div>
						</div>
						<div class="input-group">
							<span class="form-control" style="width: 80%;" onclick="document.getElementById('avatar').click();"> <span id="p-holder">Choose image</span>
							<input type="file" style="opacity: 0;" name="avatar" id="avatar" placeholder="Upload image">
						</span>
						<span class="input-group-btn" style="display: inline-block;width: 20%">
							<button class="btn btn-success" type="submit">Upload!</button>
						</span>
						@if ($errors->has('avatar'))
						{{ Session()->get('test') }}
						<span class="invalid-feedback text-danger">{{  $errors->first('avatar') }}</span>
						@endif
					</div>
					<div class="ln_solid"></div>
					<a href="{{ url('employee/profile/?id=' . $employee->employee_id ) }}"><i class="fa fa-link"></i> View Profile</a>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Modal body text goes here.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection