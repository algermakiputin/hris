@extends('master')

@section('main')

<div class="page-title">
	<div class="title_left">
		<h3>Leave</h3>
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
							<h2>My Leave Balance</h2>
						</div>
						 
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content relative">
					<table class="table table-striped table-bordered no-footer">
						<thead>
							<tr>
								<th>Leave Type</th>
								<th>Allowance Per Year</th>
								<th>Consumed</th>
								<th>Balance</th>
							</tr>
						</thead>
					 	<tbody>
					 		 @for ($i = 0; $i < count($leaveTypes); $i++)
								<tr>
									<td>{{ $leaveTypes[$i]->name }}</td>
									<td>{{ $leaveTypes[$i]->allowance }} Days</td>
									<td>{{ $data[0][$i + 1] }}</td>
									<td>{{ $leaveTypes[$i]->allowance - $data[0][$i + 1] }} </td>
								</tr>
							@endfor
					 	</tbody>
					</table>
				 
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	 
	</div>
@endsection