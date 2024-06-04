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
    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">    
                    <h2>Employees/Faculty Reports</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content relative"> 
                    <div class="row">
                    <div class="col-md-6">
                    <select class="form-control" style="max-width:200px" id="employee-reports-sorting">
                        <option>Select sort options</option>
                        <option value="gender">Sex</option>
                        <option value="birthday">Age</option>
                        <option value="employment_type">Employment Status</option>
                        <option value="date_joining">Years of Service</option>
                    </select>
                    </div> 
                    <button id="employeesExportToPDF" class="btn btn-default pull-right">Export to PDF</button>
                    </div>
                    <table class="table table-stripped table-hover table-bordered" id="employees-report-table">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Contact No.</th>
                                <th>School/Office</th>
                                <th>Position</th>
                                <th>Employment Type</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection