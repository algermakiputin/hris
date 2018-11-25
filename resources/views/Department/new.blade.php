@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Department</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">New Department</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>New Department</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
			 
				<form class="form-horizontal form-label-left" method="POST" action="{{ url('department/save') }}" id="new_department_form">
					@csrf

					@if (session()->has('success')) 
				 		<div class="form-group">
							<div class="col-md-offset-4 col-md-4 col-sm-4 col-xs-12">
								 <span class="text-success"><b>Success!</b> {{ session()->get('success') }}</span>
							</div>
						</div>
				 	@endif
				 	<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Department Name: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="department_name"  required="required" placeholder="Name">
						</div>
							 
					</div>
				 	<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12" >
							Campus: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select class="form-control" name="campus_id" required="required">
								<option value="">Select Campus</option>
								@foreach($campuses as $campus)
								<option value="{{ $campus->id }}">{{ $campus->name }}</option>
								@endforeach
							</select>
						</div>
							 
					</div>
					
				 	
				 	<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Details:
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" class="form-control col-md-7 col-xs-12" name="description" placeholder="Details" required="required">
						</div>	 
					</div>
			 

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">&nbsp; 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12 text-right">
							<button class="btn btn-success" type="submit">Save</button>
						</div>	 
					</div>
 
				</form>
			</div>
		</div>
	</div>
</div>

@endsection