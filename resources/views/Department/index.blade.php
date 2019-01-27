@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Department</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Department</li>
			</ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Department Lists</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>

				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table class="table table-striped table-bordered no-footer" id="department_table">
					<thead>
						<tr>
							<th>Campus</th>
							<th>Department Name</th>
							<th>Description</th> 
							<th>Action</th>
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


<div class="modal" tabindex="-1" role="dialog" aria-hidden="true" id="modal-heads">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<div class="modal-header ">
				<h4 class="modal-title" id="header">Department Heads</h4> 			 
			</div>
			<div class="modal-body">
				<p>Drag and drop to order department heads</p>
				<ul class="list-group" id="department-heads-list">
					<li class="list-group-item">Empty</li>
				</ul> 
				<input type="hidden" name="department_id" value="" id="department_id">
				<input type="hidden" name="campus_id" value="" id="campus_id">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-department-heads" id="department-head">Add</button>
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="add-department-heads" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="vertical-align: middle;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLongTitle">Add Department Heads</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label>Select Employee</label>
						<select id="select-employee" name="select-employee" class="form-control" >
							<option value="">Select Employee</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="save-department-head">Save</button>
			</div>
		</div>
	</div>
</div>

@endsection