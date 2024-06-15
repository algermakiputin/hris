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
		    <li class="breadcrumb-item active" aria-current="page">New Request</li>
		  </ol>
		</nav>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title" id="x_title">
				<h2>New Request</h2>
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
						{{ Form::open(['class' => 'form-horizontal form-label-left','files' => true, 'url' => 'request/store', 'autocomplete' => 'off','id' => 'request_form'])}}
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
                                <label>Type of request</label>
                                <select name="type" class="form-control" id="request-type">
                                    <option>Service Records</option> 
                                    <option>Certification of Employment</option>
                                    <option>SSS Filed Benefits</option>
                                    <option>Philhealth Benefits</option>
                                    <option>Pag-ibig Claims</option>
                                    <option>Employment Verification</option>
                                </select>
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

<script>
    

</script>