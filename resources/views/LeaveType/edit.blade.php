@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Edit Leave Type</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit Leave Type</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2><a href="{{ url('leave-types') }}">Return</a></h2>
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
				{{ Form::open(['class' => 'form-horizontal form-label-left', 'url' => 'leave-type/update', 'id' => 'leave_type_form'])}}
					@method('put')
					@csrf
					<fieldset>
						<input type="hidden" name="id" value="{{ $type['id'] }}">
					 
						<div class="col-md-offset-4 col-md-8">
							<h2>Edit Leave Type</h2>
						</div>
					 	@if (session()->has('success')) 
					 		<div class="form-group">
								<div class="col-md-offset-4 col-md-4 col-sm-4 col-xs-12">
									 <span class="text-success"><b>Success!</b> {{ session()->get('success') }}</span>
								</div>
							</div>
					 	@endif
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Name: 
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="name"  class="form-control col-md-7 col-xs-12" name="name" required="required" value="{{ $type->name }}">
							</div>	 
						</div>
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Campus:
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select name="campus" class="form-control" id="select_role_campus">
									<option value="">Select Campus</option>
									@foreach ($campuses as $campus)
										<option {{ $campus_id == $campus->id ? 'selected' : '' }} value="{{ $campus->id }}">{{$campus->name}}</option>
									@endforeach
								</select>
							</div>	 
						</div>
					 	<div class="form-group" id="campus-department">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">Department: 
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select name="department" class="form-control campus-department-select" id="campus-department-select">
									<option value="">Select Department</option>
									@foreach($departments as $department)
									<option {{ $department_id == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
									@endforeach
								</select>
							</div>	 
						</div> 
					 	
					 	<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Allowance per year: 
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="number" id="allowance"  class="form-control col-md-7 col-xs-12" name="allowance" required="required" value="{{ $type->allowance }}">
							</div>	 
						</div>
						
					 	<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Details: 
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="description"  class="form-control col-md-7 col-xs-12" name="description" required="required" value="{{ $type['description'] }}">
							</div>	 
						</div>

						
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">&nbsp; 
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12 text-right">
								<button type="submit" class="btn btn-success">Save</button>
							</div>	 
						</div>

					</fieldset>
 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection