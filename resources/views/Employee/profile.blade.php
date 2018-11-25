@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Profile</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Profile</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				@if (Auth()->user()->employee_id == $profile->employee_id)
				<h2>My Profile</h2>
				@else 
				<h2>Employee Profile</h2>

				@endif
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>

				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
					<div class="profile_img">
						<div id="crop-avatar">
							@if ($profile->avatar)
							<img class="img-responsive avatar-view" src="{{ url('storage/avatar') .'/' . $profile->avatar }}" alt="Avatar" title="Change the avatar">
							@else
							<img class="img-responsive avatar-view" src="{{ url('images/default.png') }}" alt="Avatar" title="Change the avatar">
							@endif
						</div>
					</div>
					<h3>{{ ucfirst($profile->first_name) . ' ' . ucfirst($profile->last_name) }}</h3>

					<ul class="list-unstyled user_data">
						<li><i class="fa fa-map-marker user-profile-icon"></i> {{ ($address->address) ?? "Not specified" }}
						</li>

						<li>
							<i class="fa fa-briefcase user-profile-icon"></i> {{ $profile->role_name }}
						</li>
					</ul>

					<form method="get" action="{{ url('employee/edit') }}">
						<input type="hidden" name="id" value="{{ $profile->employee_id }}">
						<button class="btn btn-success" type="submit"><i class="fa fa-edit m-right-xs"></i>Edit Profile</button>
					</form>
					<br>

				</div>
				<div class="col-md-9 col-sm-9 col-xs-12" id="profile-section">
					<div class="" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active"><a href="#personal" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Personal Details</a>
							</li>
							<li role="presentation" class=""><a href="#employment" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Employment Details</a>
							</li>
							<li role="presentation" ><a href="#files" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Documents</a>
							</li>
							@if ( $profile->employment_type !== 1 )
							<li role="presentation" ><a href="#schedule" role="tab" data-toggle="tab" aria-expanded="true">Schedules</a>
							</li>
							@endif
						</ul>
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade" id="schedule">
								<table class="table table-stripped">
									<tr>
										<th colspan="3"><i class="fa fa-clock-o"></i> Schedules</th>
									</tr>
									<tr>
										<th>Day</th>
										<th>Start</th>
										<th>End</th>
									</tr>
									@if (count($schedules))
									@foreach($schedules as $schedule)
									<tr>
										<td>{{ config('config.weekOfDay')[(int)$schedule->day - 1] }}</td>
										<td>{{ date('h:i a', strtotime($schedule->start)) }}</td>
										<td>{{ date('h:i a', strtotime($schedule->end)) }}</td>
									</tr>
									@endforeach
									@else 
									<tr>
										<td colspan="3" class="text-center">Schedule not set</td>
									</tr>
									@endif
								</table>
							</div>
							<div role="tabpanel" class="tab-pane fade active in" id="personal" aria-labelledby="home-tab">
								<table class="table table-stripped">
									<tr>
										<th colspan="2"><i class="fa fa-pencil"></i> Personal Details</th>
									</tr>
									<tr>
										<td>Gender</td>
										<td>{{ $profile->gender == 1 ? 'Male' : 'Female'}}</td>
									</tr>
									<tr>
										<td>Birthday:</td>
										<td>{{ $profile->birthday }}</td>
									</tr>
									<tr>
										<td>Age:</td>
										<td>{{ $age }}</td>
									</tr>
									<tr>
										<td>Email:</td>
										<td>{{ $profile->email_address }}</td>
									</tr>
									<tr>
										<td>Mobile Number:</td>
										<td>{{ $profile->mobile }}</td>
									</tr>
									<tr>
										<td>Telephone:</td>
										<td>{{ $profile->telephone ? $profile->telephone : 'N/A' }}</td>
									</tr>
									<tr>
										<td>Marital Status:</td>
										<td>{{ ucfirst($profile->marital_status) }}</td>
									</tr>

								</table>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="employment" aria-labelledby="profile-tab">

								<table class="table">
									<tr>
										<th colspan="2"><i class="fa fa-briefcase"></i> Employment Details</th>
									</tr>
									<tr>
										<td>Campus:</td>
										<td>{{ ucfirst($profile->campus_name) }}</td>
									</tr>
									<tr>
										<td>Department:</td>
										<td>{{ ucwords($profile->department_name) }}</td>
									</tr>
									<tr>
										<td>Designation:</td>
										<td>{{ ucfirst($profile->role_name) }}</td>
									</tr>
									<tr>
										<td>Employment Type:</td>
										<td>{{ $profile->employment_type === 1 ? "Full Time" : "Part Time" }}</td>
									</tr>
									<tr>
										<td>Salary:</td>
										<td>{{ config('config.currency') . number_format((float)$profile->salary) }}</td>
									</tr>
									<tr>
										<td>Date Joining:</td>
										<td>{{ $profile->date_joining }}</td>
									</tr>
									@if ($scheduleID)
									<tr>
										<td>Schedule</td>
										<td>{{ $scheduleID }}</td>
									</tr>
									@endif
								</table>

							</div>
							<div role="tabpanel" class="tab-pane fade" id="files" aria-labelledby="profile-tab">
								<table class="table">
									<tr>
										<th colspan="2"><i class="fa fa-file"></i> Documents</th>
									</tr>
									<tr>
										<td width="30%">Uploaded Resume:</td>
										<td>
											@if ($profile->resume)
											<a href="{{ asset('storage/resume') . '/' . $profile->resume }}">{{ $profile->resume }}</a>
											@else 
											N/A
											@endif
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection