@extends('master')

@section('main')

<div class="page-title">
	<div class="title_left">
		<h3>Reports</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Leave Reports</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	 
	<div class="x_panel">
		<div class="x_title">
			<div class="row">
				<div class="col-md-12">
					<h2>Employee Leave Report</h2>
				</div>
				 
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content relative" id="leaves-report">

			<table class="table table-striped table-bordered no-footer" id="leaves_report_table">
				 <thead>
				 	<tr>
				 		<th>Name</th>
				 		<th>Leave Type</th>
				 		<th>allowance</th>
				 		<th>Used</th>
				 		<th>Balance</th>
				 	</tr>
				 </thead>
				 <tbody>
				 
				</tbody>
			</table>
		</div>
	</div>
	 
		 
	<div class="clearfix"></div>
	 
</div>
@endsection