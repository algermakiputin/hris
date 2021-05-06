@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Analytics</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">employees</li>
		  </ol>
		</nav>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Tardiness Classification</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<h5>Common Variables</h5>
				<p>Employees who are Male, Age 36 to 45 he is working over 10 years as a teacher in college department who lives in Matina, he has asthma had tend to had more days of tardiness that other characteristics.</p>
				<table class="table table-striped table-bordered no-footer" id="classification_table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Age</th>
							<th>Position</th>
							<th>Department</th>	  						 	
							<th>Status</th>
						 	<th>Late</th>
						</tr>
					</thead>
					<tbody> 
					 	<tr>
					 		<td>John Doe</td>
					 		<td>38</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>Frequently Late</td>
					 	</tr>
					 	<tr>
					 		<td>Mac Doe</td>
					 		<td>38</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>Moderate Late</td>
					 	</tr>
					 	<tr>
					 		<td>Morry Summer</td>
					 		<td>42</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>Frequently Late</td>
					 	</tr>
					 	<tr>
					 		<td>King David</td>
					 		<td>39</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>Frequently Late</td>
					 	</tr>
					 	<tr>
					 		<td>Thompson David</td>
					 		<td>44</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>No Late</td>
					 	</tr>
					 	<tr>
					 		<td>Clark Williams</td>
					 		<td>45</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>No Late</td>
					 	</tr>
					 	<tr>
					 		<td>Jupiter Mars</td>
					 		<td>39</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>Frequently Late</td>
					 	</tr>
					 	<tr>
					 		<td>Levi Titan</td>
					 		<td>38</td>
					 		<td>Teacher</td>
					 		<td>College</td>
					 		<td>Active</td>
					 		<td>Frequently Late</td>
					 	</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>

 
</div>

<div class="modal fade employees" tabindex="-1" role="dialog" aria-hidden="true" id="modal-confirmation">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title text-danger" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Warning</h4>
			</div>
			<div class="modal-body">
				<h5>Are you sure you want to permanently delete that employee?</h5>
			 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger btn-sm" id="yes">Yes</button>
			</div>

		</div>
	</div>
</div>
@endsection