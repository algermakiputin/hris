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
				<li class="breadcrumb-item active" aria-current="page">Leave Balance</li>
			</ol>
		</nav>
	</div>
</div>

<div class="row">

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-5">
						<h2>Leaves Calendar</h2>
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content relative">
				<div class="row">
					<div class="col-md-12">
						<div id="leave-calendar" style="z-index: 1"></div>
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
				<h4 class="modal-title" id="leave-title">Leave Details</h4>
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
@endsection