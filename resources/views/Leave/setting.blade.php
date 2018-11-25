@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>New Department</h3>
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
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			

				 
			<div class="x_title" id="x_title">
				<h2>Department</h2>
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
				<form id="employee-add" data-parsley-validate class="form-horizontal form-label-left">

					<fieldset class="form-step active" step-no = '1'>
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Department Name  
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="fname" placeholder="">
							</div>	 
						</div>
					 	
					 	<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Details 
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="fname" placeholder="">
							</div>	 
						</div>

						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Department Head  
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="fname" placeholder="">
							</div>	 
						</div>

						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">&nbsp; 
							</label>
							<div class="col-md-4 col-sm-4 col-xs-12 text-right">
								<button type="submit" class="btn btn-success next">Submit</button>
							</div>	 
						</div>

					</fieldset>
 
				</form>
			</div>
		</div>
	</div>
</div>
@endsection