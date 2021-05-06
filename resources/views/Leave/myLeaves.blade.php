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
		    <li class="breadcrumb-item active" aria-current="page">My Leaves</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>My Leaves</h2>
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
							<h3>My leave applications</h3>
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
				 
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped table-bordered" id="my_leaves">
							<thead>
								<tr>
									<th>Leave Type</th>
									<th>Date</th> 
									<th>From</th>
									<th>To</th> 
									<th>Status</th> 
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
				 
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

<div class="modal fade" id="summary" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-info-circle"></i> Leave Details</h4>
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
				<h4 class="modal-title">Department Heads Approval</h4>
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

<div class="modal" tabindex="-1" role="dialog" id="leave-balance">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-bed"></i> My Leave Balance</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
			<tr>
				<th class="text-center" >Type</th>
				<th class="text-center">Allowance Per School Year</th>
				<th class="text-center">Used</th>
				<th class="text-center">Balance</th>
			</tr>
		 
			@if ($leave_types)
				@foreach($leave_types as $l)
				<tr>
					<td class="text-center">{{$l['name']}}</td>
					<td class="text-center">{{$l['allowance']}} Days</td>
					<td class="text-center">{{ $l['used'] }}</td>
					<td class="text-center">{{ $l['balance'] }}</td>
				</tr>
				@endforeach
			@else
				<tr>
					<td class="text-center" colspan="4">No leave allocated for you department</td>
				</tr>
			@endif
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div> 
  </div> 
</div>
<script type="text/javascript">
	var balance = "{{ json_encode($leave_types) }}";
</script>
@endsection

@section('js')
	<script src="{{ url('page/js/leaves.js')}}"></script>
@endsection