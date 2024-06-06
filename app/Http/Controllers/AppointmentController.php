<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\Department;
use App\Appointment;
use App\employee;
use App\Roles;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index() {
        $employee = employee::where('employee_id', Auth()->user()->employee_id)->first();
        $campus = Campus::where('id', $employee->campus_id)->first();
        $department = Department::where('campus_id', $employee->campus_id)->first();
        $appointments = Appointment::where('employee_id', $employee->employee_id)->get();
        $role = Roles::where('id', $employee->role_id)->first();  
        return view('Appointment.index', compact('employee', 'campus', 'department', 'appointments', 'role'));
    }

    public function new() {
        $campuses = Campus::all();
        $departments = Department::all();
        return view('Appointment.new', compact('campuses', 'departments'));
    }

    public function store(Request $request) {
        Appointment::create([
            'campus_id' => $request->input('campus'),
            'employee_id' => Auth()->user()->employee_id,
            'date_time' => $request->input('leave_date'),
            'reason' => $request->input('reason'),
            'status' => 'pending',
            'department_id' => $request->input('department')
        ]);

        return redirect()->back();
    }

    public function adminAppointments() {
		return view('Appointment.admin-appointment');
	}

    public function appointmentsDatatable(Request $request) {  
		$limit = $request->input('length') || 10;
		$start = $request->input('start') || 0;  
		$appointments = Appointment::offset($start)
                                    ->limit($limit)
                                    ->orderBy('id', 'DESC') 
                                    ->get();
        $count = Appointment::count();
        $data = [];

        foreach ($appointments as $appointment) {
            $employee = employee::where('employee_id', $appointment->employee_id)->first();
            $campus = Campus::where('id', $employee->campus_id)->first();
            $department = Department::where('campus_id', $employee->campus_id)->first();
            $appointments = Appointment::where('employee_id', $employee->employee_id)->get();
            $role = Roles::where('id', $employee->role_id)->first();  
            $data[] = [
                $campus->name,
                $employee->first_name . ' ' . $employee->last_name,
                $department->name,
                $role->name,
                $appointment->date_time,
                $appointment->reason,
                $appointment->status,
                '<button data-status="'.$appointment->status.'" data-id="'.$appointment->id.'" class="btn btn-success update-appointment-link">Update</button>'
            ];
        } 
		$jsonData = array(
			'draw' => $request->input('draw'),
			'recordsTotal' => $count,
			'recordsFiltered' => $count,
			'data' => $data 
		); 
		echo json_encode($jsonData);
    }

    public function update(Request $request) {
        $appointment = Appointment::find($request->input('id'));
        $appointment->status = $request->input('status');
        $appointment->save();
        return redirect()->back();
    }
}
