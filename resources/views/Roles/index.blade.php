@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Roles</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Roles</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Roles Lists</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<table class="table table-striped table-bordered no-footer" id="roles_table">
					<thead>
						<tr> 
							<th>Name</th>
							<th>Description</th>
							<th>Total Employees</th>
							<th>Actions</th> 
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
 
</div>
@endsection