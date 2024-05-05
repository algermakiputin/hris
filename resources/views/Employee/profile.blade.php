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
						<input type="hidden" name="id" value="{{ $profile->id }}">
						<button class="btn btn-success" type="submit"><i class="fa fa-edit m-right-xs"></i> Edit</button>
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
							<li role="presentation" ><a href="#schedule" role="tab" data-toggle="tab" aria-expanded="true">Schedule </a>
							</li>
							<li role="presentation" ><a href="#education" role="tab" data-toggle="tab" aria-expanded="true">Education </a>
							</li>
							<li role="presentation" ><a href="#work" role="tab" data-toggle="tab" aria-expanded="true">Work </a>
							</li>
						</ul>
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade" id="schedule">
								<table class="table table-striped table-bordered table-hover">
									<tr>
										<th colspan="3"><i class="fa fa-clock-o"></i> Schedule </th>
									</tr> 
									@if (count($schedules))
										@foreach($schedules as $key => $schedule)
											<tr>
									 			<th colspan="4">{{  config('config.weekOfDay')[$key - 1] }}</th>
									 		</tr> 
											@foreach ($schedule as $sched) 
											<tr>
												<td>{{ config('config.weekOfDay')[(int)$sched->day - 1] }}</td>
												<td>{{ date('h:i a', strtotime($sched->start)) }}</td>
												<td>{{ date('h:i a', strtotime($sched->end)) }}</td>
											</tr>
											@endforeach
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
									<tr>
										<td>Education Level:</td>
										<td>{{ $profile->education }}</td>
									</tr> 
									<tr>
										<td>Religious Affiliation:</td>
										<td>{{ $profile->religiousAffiliation }}</td>
									</tr>
									<tr>
										<td>Height:</td>
										<td>{{ $profile->height }}</td>
									</tr>
									<tr>
										<td>Weight:</td>
										<td>{{ $profile->weight }}</td>
									</tr>
									<tr>
										<td>Blood Type:</td>
										<td>{{ $profile->bloodType }}</td>
									</tr>
									<tr>
										<td>Tin:</td>
										<td>{{ $profile->tin }}</td>
									</tr>
									<tr>
										<td>SSS:</td>
										<td>{{ $profile->sss }}</td>
									</tr>
									<tr>
										<td>Philhealth:</td>
										<td>{{ $profile->philhealth }}</td>
									</tr>
									<tr>
										<td>Citizenship:</td>
										<td>{{ $profile->citizenship }}</td>
									</tr>
									<tr>
										<td>Unit:</td>
										<td>{{ $profile->unit }}</td>
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
										<td>Tenure:</td>
										<td>{{ $profile->tenure }}</td>
									</tr>
									<tr>
										<td>Salary:</td>
										<td>{{ config('config.currency') . number_format((float)$profile->salary) }}</td>
									</tr>
									<tr>
										<td>Date Joining:</td>
										<td>{{ $profile->date_joining }}</td>
									</tr>
									<tr>
										<td>Employment Status:</td>
										<td>{{ $profile->employment_status }}</td>
									</tr>
									<tr>
										<td>Designation:</td>
										<td>{{ $profile->designation2 }}</td>
									</tr>
									<tr class="{{ $profile->designation2 !== 'Faculty' ? 'hide' : '' }}">
										<td>Academic Rank:</td>
										<td>{{ $profile->academic_rank }}</td>
									</tr>
									<tr class="{{ $profile->designation2 !== 'Employee' ? 'hide' : '' }}">
										<td>Administrative Rank:</td>
										<td>{{ $profile->administrative_rank }}</td>
									</tr>
									<tr>
										<td>Honorarium:</td>
										<td>{{ $profile->honorarium }}</td>
									</tr>
									<tr>
										<td>Honorarium Expiry:</td>
										<td>{{ $profile->honorarium_expiry }}</td>
									</tr>
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
							<div role="tabpanel" class="tab-pane fade" id="education" aria-labelledby="education-tab"> 
								<table class="table table-stripped table-hover" id="educational-background" width="100%">
									<thead>
										<th width="10%">Level</th>
										<th width="20%">School</th>
										<th width="20%">Degree</th>
										<th width="20%">Year Graduated</th>
										<th width="10%">Highes Grade/Level/Units Earned(if not graduated)</th>
										<th width="10%">Inclusive dates of attendance from - to</th>
										<th width="10%">Scholarship/Academic honors received</th> 
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
								<div>
									<div class="card">
										<div class="card-header"><b>Involvement In Other Educational Or Professional Organization</b> </div>
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
												@if($profile->involvement)
													@foreach($profile->involvement as $involvement)
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
										<div class="card-header"><b>Involvement In Other CIVIC (Non Government/People) Voluntary Organization</b></div>
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
												@if($profile->voluntary)
													@foreach($profile->voluntary as $voluntary)
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
							</div>
							<div role="tabpanel" class="tab-pane fade" id="work" aria-labelledby="work-tab"> 
								<div class="card">
									<div class="card-header"><b>Work Experience</b></div>
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
											@if($profile->work)
												@foreach($profile->work as $work)
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
								<div class="card">
									<div class="card-header"><b>Other Information</b></div>
									<div class="card-body">
										<form action="{{ url('employeeInfo/store') }}" method="POST" id="work-exp-form">
											@csrf
											@method('post')
											<input type="hidden" value="{{ $profile->id }}" name="id" />
											<table class="table">
												<tr>
													<th>Special Skills/Hobbies</th>
													<th>Non-Academic Distinction/Recognition/Awards</th>
												</tr>
												<tr>
													<td><textarea readonly name="hobbies" rows="6" class="form-control">{{ $profile->hobbies }}</textarea></td>
													<td><textarea readonly name="awards" rows="6" class="form-control">{{ $profile->awards }}</textarea></td>
												</tr>
											</table> 
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection