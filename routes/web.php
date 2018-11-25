<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']],function() {
	Route::get('/', 'AppController@index'); 
	//Employee
	Route::get('employee', 'EmployeeController@index');
	Route::get('employee/profile','EmployeeController@profile');
	Route::post('employee/data','EmployeeController@data');
	Route::get('leave/application','LeaveController@application');
		 
	Route::get('employee/edit','EmployeeController@edit');
	Route::post('employee/upload-avatar','EmployeeController@uploadAvatar');
	Route::patch('employee/update','EmployeeController@update');
	Route::patch('employee/update-employment', 'EmployeeController@updateEmploymentDetails');
	Route::patch('employee/resume/update','EmployeeController@resumeUpdate');

	//Campus 
	Route::get('campus','CampusController@index');
	Route::post('campus/data','CampusController@data');
	Route::get('campus/getCampuses','CampusController@getCampuses');
	//Department
	Route::get('department','DepartmentController@index');
	Route::post('department/data','DepartmentController@data');
	
	//Leave
	Route::get('leaves', 'LeaveController@index');
	Route::post('leave/insert','LeaveController@insert');
	Route::post('leave/data','LeaveController@data');
	Route::post('leave/approve','LeaveController@approve');
	Route::post('leave/decline','LeaveController@decline');
	Route::get('leaves/calendar','LeaveController@calendar');
	Route::post('leaves/getCalendar','LeaveController@getCalendar');
	
	Route::get('my-leaves','LeaveController@myLeave');
	Route::post('my-leaves/data','LeaveController@myLeaveData');
	Route::post('my-leaves/delete','LeaveController@myLeaveDelete');
	Route::get('my-leaves/balance','LeaveController@myLeaveBalance');
	Route::post('my-leaves/summary','LeaveController@summary');
 
	Route::post('leaves/summary','LeaveController@summary');
	Route::post('leaves/general-report','LeaveController@generalReports');

	Route::post('leaves-approval/insert', 'LeaveApprovalsController@insert');
	
	Route::get('reports/general','ReportsController@general');
	Route::post('reports/all','ReportsController@all');

	Route::get('calendar','CalendarController@calendar');
	Route::get('calendar/events','CalendarController@events');

	Route::group(['middleware' => ['CheckRole']], function() {
		//Employee
		Route::get('employee/new', 'EmployeeController@new');
		Route::post('employee/insert','EmployeeController@insert');
		Route::post('employee/destroy','EmployeeController@destroy');

		//Campus
		Route::get('campus/new','CampusController@new');
		Route::post('campus/save','CampusController@save');
		Route::get('campus/edit','CampusController@edit');
		Route::patch('campus/update','CampusController@update');
		Route::post('campus/delete','CampusController@destroy');
		Route::post('campus/getDepartments','CampusController@getDepartments');
		//Department
		Route::get('department/edit','DepartmentController@edit');
		Route::put('department/update','DepartmentController@update');
		Route::get('department/new','DepartmentController@new');
		Route::post('department/save', 'DepartmentController@save');
		Route::post('department/destroy','DepartmentController@destroyRow');
		Route::post('departmentHeads/getEmployees', 'DepartmentHeadsController@getEmployees');
		Route::post('departmentHeads/insert','DepartmentHeadsController@insert');
		Route::get('departmentHeads/get', 'DepartmentHeadsController@get');
		Route::post('departmentHeads/destroy', 'DepartmentHeadsController@destroy');
		Route::post('departmentHeads/order','DepartmentHeadsController@order');
		//Leaves
		Route::get('leave/setting','LeaveController@setting');
		
		Route::get('reports/leaves', 'LeaveController@report');
		Route::post('leave/reports','LeaveController@reportsData');
		Route::post('leave/employee-report','LeaveController@employeeReport');

		Route::get('leave-types','LeaveTypeController@type');
		Route::post('leave-types/data','LeaveTypeController@data');
		Route::get('leave-types/add','LeaveTypeController@add_type');
		Route::post('leave-type/insert','LeaveTypeController@insert');
		Route::get('leave-type/edit', 'LeaveTypeController@edit');
		Route::delete('leave-type/delete', 'LeaveTypeController@destroyRow');
		Route::put('leave-type/update','LeaveTypeController@update');
		

		//Calendar
		Route::post('calendar/store','CalendarController@store');
		Route::post('calendar/update','CalendarController@update');
		Route::post('calendar/destroy','CalendarController@destroy');
		//Attendance
		Route::get('reports/attendance','AttendanceController@index'); 
		Route::get('attendance/upload','AttendanceController@upload');
		Route::post('attendance/file_upload','AttendanceController@file_upload');
		Route::post('attendance/data','AttendanceController@data');
		Route::post('attendance/report','AttendanceController@report');
		Route::get('attendance/export','AttendanceController@export');
		//Users
		Route::get('users','UsersController@index');
		Route::get('users/new', 'UsersController@new');
		Route::post('users/insert', 'UsersController@insert');
		Route::post('user/edit','UsersController@edit');
		Route::delete('user/delete/','UsersController@delete');
		Route::patch('user/update','UsersController@update');
		Route::post('users/data','UsersController@data');
		Route::get('admin/profile','UsersController@adminProfile');
		Route::get('admin/profile/edit','UsersController@adminEdit');
		Route::patch('admin/update','UsersController@adminUpdate');
		//Roles
		Route::get('roles','RolesController@index');
		Route::get('roles/new','RolesController@new');
		Route::post('role/insert','RolesController@insert');
		Route::get('roles/data','RolesController@data');
		Route::get('roles/edit','RolesController@edit');
		Route::patch('role/update','RolesController@update');
		Route::post('roles/destroy','RolesController@destroy');  

		Route::get('schedule','ScheduleController@index');
		Route::post('schedule/insert','ScheduleController@insert');
		Route::get('schedule/data','ScheduleController@data');
		Route::post('schedule/update','ScheduleController@update');
		Route::post('schedule/destroy', 'ScheduleController@destroy');

		Route::post('parttimeschedule/update', 'ParttimeScheduleController@update');

		Route::get('analytics/employee','AnalyticsController@employee');
		Route::post('analytics/employee/export','AnalyticsController@export');
	});
});
Route::get('analytics/classification', 'ClassificationController@index');
Auth::routes();

Route::get('test', 'AppController@test');
Route::get('user/set_password', 'UsersController@setPassword');
Route::patch('user/update_password','UsersController@updatePassword');
Route::get('activate-account','EmployeeController@activate_account');
Route::post('validate-account','UsersController@validateAccount'); 
Route::post('activate','EmployeeController@activate'); 