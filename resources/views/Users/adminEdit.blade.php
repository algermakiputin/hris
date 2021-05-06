@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>My Profile</h3>
	</div> 
</div>

<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Edit Profile</h2>
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
					<h3></h3>
 

				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<div class="">
				 
					<div class="x_content">
						<br />

						{{ Form::open(['url' => 'admin/update', 'files' => true ,'method' => 'POST', 'class' => 'form-horizontal form-left-label', 'id' => 'user_form']) }}
						@csrf
						@method('patch')
						@if (session()->has('success')) 

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8 col-sm-4 col-xs-12">
								<span class="text-success"><b>Success</b> {{ session()->get('success') }}</span>
							</div>
						</div>
						@endif
						<input type="hidden" name="id" value="{{ $user['id'] }}">
						 
						<div class="form-group">

							<label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">avatar:  
							</label>
							<div class="col-md-6">

								<input type="file" class="form-control" style="border: 0;box-shadow: 0;padding-left: 0;" name="avatar" id="avatar" placeholder="Upload image">


							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12" for="name">Name: 
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Full Name" required="required" data-parsley-errors-container="#error-1" value="{{ $user['name'] }}">
							</div>
							<span id="error-1"></span>	 
						</div>

						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12" for="email">Email: 
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12" >
								<input type="email" readonly="readonly" id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Email" required="required" data-parsley-errors-container="#error-2" value="{{ $user['email'] }}">
							</div>
							<span id="error-2"></span>	 
						</div>

						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12" for="role">Role:
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" readonly="readonly" id="role" class="form-control col-md-7 col-xs-12" name="role" placeholder="Role" required="required" data-parsley-errors-container="#error-2" value="{{ config('config.access')[$user['role']] }}">
							</div>
							<span id="error-3"></span>	 
						</div>


						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">&nbsp; 
							</label>
							<div class="col-md-6 col-sm-6	 col-xs-12 text-right">
								<button class="btn btn-success" type="submit">Update</button>
							</div>	 
						</div>

						{{ Form::close() }}
					</div>
				</div>

				</div>
			</div>
			 
		</div>

		@endsection