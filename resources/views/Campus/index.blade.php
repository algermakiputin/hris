@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Campus</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Campuses</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Campus Lists</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				 
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<table class="table nowrap dt-responsive table-striped table-bordered no-footer" id="campus_table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Description</th> 
							<th>Departments</th>
							<th>Total Employees</th>
							<th>Action</th>
						</tr>
					</thead>
				 
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
 
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-confirmation">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title text-danger" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Warning</h4>
			</div>
			<div class="modal-body">
				<h5>Are you sure you want to permanently delete that Campus?</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger btn-sm" id="yes">Yes</button>
			</div>

		</div>
	</div>
</div>
@endsection