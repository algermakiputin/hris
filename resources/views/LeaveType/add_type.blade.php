@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Leave Type</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">New Leave Type</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>New leave type</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />

				{{ Form::open(['class' => 'form-horizontal form-label-left', 'url' => 'leave-type/insert', 'id' => 'leave_type_form'])}}

				<fieldset class="form-step active" step-no = '1'>
					<div class="col-md-offset-4 col-md-8">
						<p>Add leave types ex. (Maternity, sick, vacation leaves)</p>
					</div>
					@if (session()->has('success')) 
					<div class="form-group">
						<div class="col-md-offset-4 col-md-4 col-sm-4 col-xs-12">
							<span class="text-success"><b>Success!</b> {{ session()->get('success') }}</span>
						</div>
					</div>
					@endif
					<div class="form-group">

						<label class="control-label col-md-4 col-sm-4 col-xs-12">Name:  
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" id="name"  class="form-control col-md-7 col-xs-12" name="name" required="required" placeholder="Name">
						</div>	 
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Campus: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select name="campus" class="form-control" id="select_role_campus">
								<option value="">Select Campus:</option>
								@foreach ($campuses as $campus)
								<option value="{{ $campus->id }}">{{$campus->name}}</option>
								@endforeach
							</select>
						</div>	 
					</div>
					<div class="form-group" style="display: none;" id="campus-department">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Department: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<select name="department" class="form-control campus-department-select" id="campus-department-select">
							</select>
						</div>	 
					</div>

					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Allowance per year:  
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="number" id="allowance"  class="form-control col-md-7 col-xs-12" name="allowance" required="required" placeholder="Allowance per year">
						</div>	 
					</div>
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Details: 
						</label>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<input type="text" id="description"  class="form-control col-md-7 col-xs-12" name="description" required="required" placeholder="Details">
						</div>	 
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">&nbsp; 
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