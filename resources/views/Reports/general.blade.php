@extends('master')

@section('main')

    <div class="page-title">
        <div class="title_left">
            <h3>General Reports</h3>
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

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-5">
                            <h2>Filter Reports</h2>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content relative">
                    <form method="POST" action="#" id="general-reports-form">
                        <div class="form-group">
                            <select required="required" data-parsley-errors-container="#a" class="form-control selectpicker" name="report" id="report-type">
                                <option value="">Select Report</option>
                                <option value="attendance">Attendance</option>
                                <option value="leave">Leave</option>
                            </select>
                            <div id="a"></div>
                        </div>
                        <div id="employment-type-wrap" style="display: none;">
                            <div class="form-group">
                                <select name="employment-type" class="form-control selectpicker">
                                    <option value="">Select Employment Type</option>
                                    <option value="1">Full Time</option>
                                    <option value="0">Part Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <select data-parsley-errors-container="#b" required="required" name="campus" class="form-control selectpicker" id="select_role_campus">
                                <option value="">Select Campus</option>
                                @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                            <div id="b"></div>
                        </div>
                        <div class="form-group">
                            <select required="required" data-parsley-errors-container="#c" name="department" class="form-control selectpicker" id="campus-department-select">
                                <option value="">Select Department</option>
                            </select>
                            <div id="c"></div>
                        </div>
                        <div class="form-group" id="sy-wrapper" style="display: none;">
                            <select name="sy" class="form-control selectpicker" id="sy">
                                <option value="">Select School Year</option> 
                            </select>
                        </div>
                        <div class="row" id="daterange" style="display: none;">
                            <div class="form-group col-md-6 ">
                                <input type="text"  class="form-control date" name="from" required="required"  placeholder="from" id="from">
                            </div>
                            <div class="form-group col-md-6 " >
                                <input type="text" class="form-control date" name="to" required="required" placeholder="to" id="to">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" id="run">Run reports</button>
                            <button class="btn btn-info" disabled="disabled"><i class="fa fa-file-excel-o"></i> Export</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">    
                    <h2>Results<span id="range"></span></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content relative">
                   <p>Select options to run reports. </p>
                   <div id="attendance" style="display: none;">
                        <table id="general-attendance" class="table table-stripped table-hover table-bordered">
                            <thead>
                                <th>Employee Name</th>
                                <th>Working</th>
                                <th>Worked</th>
                                <th>Total Hours</th>
                                <th>Total Absent</th>
                                <th>Total late</th>
                                <th>Total Overtime</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                   </div>
                   <div id="leaves" style="display: none;">
                       <table class="table table-bordered table-stripped" id="general-leave">
                           <thead>
                               <th>Employee Name</th>
                               <th>Leave Type</th>
                               <th>Allowance</th>
                               <th>Used</th>
                               <th>Balance</th>
                           </thead>
                           <tbody>
                               
                           </tbody>
                       </table>
                   </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
@endsection