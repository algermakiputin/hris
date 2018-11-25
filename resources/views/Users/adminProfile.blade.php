@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Profile</h3>
	</div>
	 
</div>

<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>My Profile</h2>
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
							<!-- Current avatar -->
							<img class="img-responsive avatar-view" src="{{ url('storage/avatar') .'/' . $user['avatar'] }}" alt="Avatar" title="Change the avatar" id="img">
						</div>
						
					</div>
					<br/>
 					<form method="GET" action="{{ url('admin/profile/edit') }}">

 						<input type="hidden" name="id" value="{{ $user->id }}">
 						<button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Edit Profile</button>
 						
 					</form>

				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="">
				 
					<div class="x_content">
						<br />
						<table class="table">
							<tr>
	                          		<th colspan="2"><i class="fa fa-pencil"></i> My Profile</th>
	                          	</tr>
							<tr>
								<td>ID</td>
								<td>{{ $user->id }}</td>
							</tr>
							<tr>
								<td>Name:</td>
								<td>{{ $user->name }}</td>
							</tr>
							<tr>
								<td>Email:</td>
								<td>{{ $user->email }}</td>
							</tr>
							<tr>
								<td>Role:</td>
								<td>{{ config('config.access')[$user->role] }}</td>
							</tr>
							
						</table>
					</div>
				</div>

				</div>
			</div>
			 
		</div>

		@endsection