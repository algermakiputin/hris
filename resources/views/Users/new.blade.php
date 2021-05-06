@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>New User</h3>
	</div>

	<div class="title_right">
		<div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search for...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">Go!</button>
				</span>
			</div>
		</div>
	</div>

</div>

<div class="row">
	@if (Session::has('success')) 
	<div class="col-md-12">
		<div class="alert alert-success fade in alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		  	<strong>Success!</strong> {{ Session::get('success') }}
		</div>
	</div>
	@endif
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>New user form</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li>
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
			 
				{{ Form::open(['url' => 'users/insert', 'method' => 'POST', 'class' => 'form-horizontal form-left-label', 'id' => 'user_form']) }}
					@csrf
				 
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Full Name  
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Full Name" required="required" data-parsley-errors-container="#error-1">
						</div>
						<span id="error-1"></span>	 
					</div>
				 	
				 	<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">Email 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="email" id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Email" required="required" data-parsley-errors-container="#error-2">
						</div>
						<span id="error-2"></span>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="role">Role 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select class="form-control" name="role" id="role" required="required" data-parsley-errors-container="#error-3">
								<option value="">Select Role</option> 
								<option value="3">System Administrator</option>
							</select>
						</div>
						<span id="error-3"></span>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="password">password 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="password" id="password" class="form-control col-md-7 col-xs-12" name="password" placeholder="Password" required="required" data-parsley-errors-container="#error-4">
						</div>	
						<span id="error-4"></span> 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="confirm">Confirm 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="password" id="confirm" class="form-control col-md-7 col-xs-12" name="password" placeholder="Confirm password" required="required" data-parsley-errors-container="#error-5" data-parsley-equalto="#password" data-parsley-equalto-message="Must be equal to your password">
						</div>
						<span id="error-5"></span>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">&nbsp; 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12 text-right">
							<button class="btn btn-success" type="submit">Register</button>
						</div>	 
					</div>
 
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@endsection