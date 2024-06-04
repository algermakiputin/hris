@extends('master')

@section('main')
<div class="page-title">
	<div class="title_left">
		<h3>Appointment</h3>
	</div>

	<div class="title_right">
		<nav aria-label="breadcrumb" class="nav navbar-right">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">New Appointment</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>New Appointment</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<div class="row">
					<div class="col-md-6" style="float: none;display: block;margin: auto;">
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
                        <div class="form-group">
                                <label>Campus</label>
                                <select name="campus" class="form-control">
                                    <option value="">Select Campus</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Deparment/Office</label>
                                <input type="text" class="form-control"  name="department"/>
                            </div>
                            <div class="form-group">
                                <label>Deparment/Office</label>
                                <div class="input-group">
                                    <input type='text' placeholder="Date Time" class="form-control" id="short_leave_date" name="leave_date"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Reason</label>
                                <input type="text" class="form-control"  name="reason"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" />
                            </div>
                        </fieldset> 
						{{ Form::close()}}
					</div>
					 
				</div>
			</div>
		</div>
	</div>
</div> 
@endsection