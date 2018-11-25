@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Leaves</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Leaves</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Leave Applications</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row top_tiles attendance-header">
					<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12">
						<div class="tile-stats"> 
							<h3>Leave applications</h3>
							<p>Total: {{ $status['application'] }}</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12">
						<div class="tile-stats"> 
							<h3>Declined</h3>
							<p>Total: {{ $status['declined'] }}</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12" id="working-wrapper">
						<div class="tile-stats"> 
							<h3>Approved</h3>
							<p>Total: {{ $status['approved'] }}</p>
						</div>
					</div>
					<div class="animated flipInY col-lg-3 col-md-2 col-sm-6 col-xs-12" id="worked-wrapper">
						<div class="tile-stats"> 
							<h3>Pending</h3>
							<p>Total: {{ $status['pending'] }}</p>
						</div>
					</div>
					 
				</div>
				<p>School Year: {{ $school_year }}</p>
				<table class="table table-striped table-bordered" id="leave_table">
					<thead>
						<tr>
							<th>Date</th>
							<th>Employee Name</th>
							<th>Leave Type</th>
							<th>From</th>
							<th>To</th> 
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					
				</table>
				<form>
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
				</form>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

<div class="modal fade" id="summary" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-info-circle"></i> <span id="leave-title">Leave Details</span> </h4>
			</div>
			<div class="modal-body">
				 <div class="row" id="leave-summary">
				 	<div class="col-md-8">
				 		<div><span id="name"></span></div>
				 		<div><span id="duration"></span></div>
				 		<div><span id="status"></span></div>
				 		<div><span id="document"></span></div>
				 		<div><span id="reason"></span></div>
				 	</div>
				 	<div class="col-md-4 text-right">
				 		<div id="leave_type">Default</div>
				 		<div id="interval">1 Day</div>
				 	</div>
				 	 
				 </div>
			</div>
			<div class="modal-header">
				<h4 class="modal-title">Department Heads Approval </h4>
				<span class="btn btn-link btn-sm" data-toggle="collapse" data-target="#leave-b" id="check-balance">View Leave Balance</span>
				<div id="leave-b" class="collapse">
					 <table class="table" id="balance-table">
						<thead>
							<tr>
								<th class="text-center" >Type</th>
								<th class="text-center">Allowance Per School Year</th>
								<th class="text-center">Used</th>
								<th class="text-center">Balance</th>
							</tr>
						</thead>
						<tbody class="text-center">
							
						</tbody>
					 	
					</table>
				</div>
			</div>
			<div class="modal-body">
				 <div class="row" id="department-heads-approval">
				  
				 </div>
			</div>
			<div class="modal-footer">
				<span id="action-btns" style="display: none;">
					<button class="btn btn-success btn-sm" id="approve">Approve</button>
					<button class="btn btn-danger btn-sm" id="decline">Decline</button>
				</span>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
			</div>
		</div>
	</div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="leave-balance">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-info-circle"></i> Leave Balance</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div> 
  </div> 
</div> 
@endsection