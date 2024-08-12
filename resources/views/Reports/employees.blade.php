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
                    <div class="col-md-3">
                        <select class="form-control" style="max-width:200px" id="employee-reports-sorting">
                            <option>Select sort options</option>
                            <option value="gender">Sex</option>
                            <option value="birthday">Age</option>
                            <option value="employment_type">Employment Status</option>
                            <option value="date_joining">Years of Service</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="gender-select">
                        <select class="form-control" style="max-width:200px" >
                            <option>Select Gender</option>
                            <option value="1">Male</option>
                            <option value="0">Female</option> 
                        </select>
                    </div>
                    <div class="col-md-3" id="age-select">
                        <select class="form-control" style="max-width:200px" >
                            <option>Select Age</option>
                            <option value="20-30">20-30</option>
                            <option value="31-40">31-40</option> 
                            <option value="41-50">41-50</option> 
                            <option value="51-60">51-60</option> 
                            <option value="61+">60+</option> 
                        </select>
                    </div>
                    <div class="col-md-3" id="employment-status-select">
                        <select class="form-control" style="max-width:200px" >
                            <option>Select Employment Status</option>
                            <option value="Project Baesd">Project Based</option>
                            <option value="Contractual">Contractual</option> 
                            <option value="Permanent">Permanent</option> 
                            <option value="Privisionary">Privisionary</option> 
                            <option value="Part Time">Part Time</option> 
                        </select>
                    </div>
                    <div class="col-md-3" id="service-select">
                        <select class="form-control" style="max-width:200px" >
                            <option>Select Years of Service</option>
                            <option value="less">Less than 1 year</option>
                            <option value="1-5">1-5</option>
                            <option value="6-10">6-10</option> 
                            <option value="11-20">11-20</option>
                            <option value="20+">20+</option>
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
<style>
    #gender-select {
        display:none;
    }
    #age-select {
        display:none;
    }
    #service-select {
        display:none;
    }
    #employment-status-select {
        display:none;
    }
</style>
<script>
    $(document).ready(function() {
        $("#employee-reports-sorting").change(function() {
            var option = $(this).val();
            if (option == "gender") {
                hideAllFilter();
                $("#gender-select").show();
            } else if (option == "birthday") {
                hideAllFilter();
                $("#age-select").show();
            } else if (option == "employment_type") {
                hideAllFilter();
                $("#employment-status-select").show();
            } else if (option == "date_joining") {
                hideAllFilter();
                $("#service-select").show();
            }
        });

        function hideAllFilter() {
            $("#gender-select").hide();
            $("#employment-status-select").hide();
            $("#age-select").hide();
            $("#service-select").hide();
        }
    })
</script>
@endsection