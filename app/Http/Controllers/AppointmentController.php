<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\Department;
use App\Appointment;

class AppointmentController extends Controller
{
    public function index() {
        return view('Appointment.new');
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
}
