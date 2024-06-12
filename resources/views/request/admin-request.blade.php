@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Request</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Request</li>
			</ol>
		</nav>
	</div> 
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>File Request</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content"> 
				<table class="table table-striped table-bordered" id="admin-request-table">
					<thead>
						<tr>
                            <th>Date</th>
							<th>Employee ID</th>
							<th>Name</th>
							<th>Type</th>
							<th>File</th> 
                            <th>Status</th>
							<th></th>
						</tr>
					</thead>
                    <tbody>
                        @foreach($requests as $request) 
                        <tr>
                            <td>{{ $request->created_at }}</td>
                            <td>{{ $request->employee_id }}</td>
                            <td>{{ $request->employeeName }}</td>
                            <td>{{ $request->type }}</td>
                            <td>{{ $request->file }}</td>
                            <td>{{ $request->status }}</td>
                            <td><button class="btn btn-sm btn-primary request-update" data-id="{{ $request->id }}">Update</button></td>
                        </tr>
                        @endforeach
                    </tbody>
				</table>
				<form>
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
				</form>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div> 


<div class="modal fade" tabindex="-1" role="dialog" id="request-update-modal">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-info-circle"></i> Update Request</h4>
      </div>
      <div class="modal-body">
      {{ Form::open(['class' => 'form-horizontal form-label-left','files' => true, 'url' => 'leave/insert', 'autocomplete' => 'off','id' => 'leave_application_form'])}}
        @if ($errors->any()) 
            <div class="form-group">
                <div class="col-md-offset-3 col-md-9 col-sm-4 col-xs-12">
                        <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>	
                    </div>
                </div>
            </div> 
        @endif
        <fieldset>   
            @if (session()->has('success')) 
            <div class="form-group">
                <div class="col-md-offset-3 col-md-9 col-sm-4 col-xs-12">
                        <span class="text-success"><b>Success!</b> {{ session()->get('success') }}</span>
                </div>
            </div>
            @endif    
            <div class="form-group">
                <label>Employee Name</label>
                <input type="text" disabled class="form-control"  id="request-employee-name" name="name"/>
            </div>
            <div class="form-group">
                <label>Type</label>
                <input type="text" disabled class="form-control"  id="request-type" name="type"/>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="request-status" name="status">
                    <option>Pending</option>
                    <option>Done</option>
                    <option>Rejected</option>
                </select>
            </div>
            <div class="form-group">
                <label>File</label>
                <input type="file" name="file" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit"/>
            </div>
        </fieldset>
    {{ Form::close()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div> 
  </div> 
</div> 
@endsection