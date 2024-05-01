<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Roles;
use App\Attendance;
use App\employee;
use App\address;
use App\Department;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class ReportsController extends Controller
{
    public function general() {
    		$campuses = Campus::all();
    		$roles = Roles::all();
           
        	return view('Reports.general',compact('campuses','roles'));
    }

    public function employees() {
        $employees = employee::all();
        return view('Reports.employees');
    }

    public function datatable(Request $request) {
        $draw = $request->input('draw');
        $limit = $request->input('length');
		$start = $request->input('start');
        $sort = $request->input('columns.0.search.value') ? $request->input('columns.0.search.value') : "first_name";
        $employees = employee::orderBy($sort, 'ASC')
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        $count = employee::count();
        $data = [];

        foreach ($employees as $employee) {
            $address = address::where('employee_id', $employee->id)->first();
            $role = Roles::where('id', $employee->role_id)->first();
            $department = Department::where('id', $employee->department_id)->first();
            $birthDate = Carbon::parse($employee->birthday);
            $today = Carbon::now();
            $age = $birthDate->diffInYears($today);
            $data[] = [
                $employee->id,
                $employee->first_name . " " . $employee->last_name,
                $address ? $address->address : '',
                $employee->gender === 0 ? "F" : "M",
                $age,
                $employee->mobile,
                $department ? $department->name : '',
                $role ? $role->name : '',
                $employee->employment_type === 1 ? "Full Time" : "Part Time" 
            ];
        }

        echo json_encode(array(
            'draw' => $draw,
            'recordsTotal' => $count,
			'recordsFiltered' => $count,
			'data' => $data
        ));
    }

    public function leaveSearch(Request $request) {
        $datasets = [];
        $leave = new LeaveController;
        $start_sy = $request->input('sy') . '-' . config('config.school_year.start') . '-1';
      
        $end_sy = (int)$request->input('sy') + 1 . '-' . config('config.school_year.end') . '-31';
        $employees = employee::where([
                                'status' => 1, 
                                'campus_id' => $request->input('campus'),
                                'department_id' => $request->input('department')
                            ])->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'LIKE', '%'. $request->input('q') . '%')
                            ->get();

        foreach ($employees as $employee) {
            $leave_types = $leave->getEmployeeLeaveBalance($employee->department_id, $employee->employee_id, $employee->campus_id, $start_sy, $end_sy);
            if (!$leave_types) {
                $datasets[] = [0,$employee->first_name . ' ' . $employee->last_name];
                continue;
            }
            $leave_types[0] = $leave_types[0] + ['employee' => $employee->first_name . ' ' . $employee->last_name];
            
            $datasets[] = $leave_types;
           
        }

        return json_encode($datasets);
    }

    public function all(Request $request) {
        	$type = $request->input('type');
            $campus = $request->input('campus');
            $department = $request->input('department');
            $employmentType = (int)$request->input('employmentType');
        	$datasets = [];

        	if ($type === "attendance") {
                $attendance = new AttendanceController;
        		$employees = employee::where([
                                        'status' => 1, 
                                        'campus_id' => $campus,
                                        'department_id' => $department,
                                        'employment_type' => $employmentType
                                    ])->get();

        		foreach ($employees as $employee) {
        			$data = array(
        					'campus_id' => $employee->campus_id,
        					'employee_id' => $employee->employee_id,
        					'start_date' => $request->input('from'),
        					'end_date' => $request->input('to')
        				);
        			$request->request->add($data);
        			$report = $attendance->report($request);
        			$report = json_decode($report, true);
                
        			$datasets[] = [
        				'name' => $report['name'],
                        'working' => $report['working'],
                        'worked' => $report['worked'],
        				'total_hours' => $report['total_hours'],
        				'total_absent' => $report['absent'],
        				'total_late' => $report['late'],
        				'total_overtime' => $report['overtime']
        			];
        		}

        		return json_encode($datasets);

        	}else if ($type == "leave") { 

                $leave = new LeaveController;
                $start_sy = $request->input('sy') . '-' . config('config.school_year.start') . '-1';
              
                $end_sy = (int)$request->input('sy') + 1 . '-' . config('config.school_year.end') . '-31';
                $employees = employee::where([
                                        'status' => 1, 
                                        'campus_id' => $campus,
                                        'department_id' => $department
                                    ])->get();

                foreach ($employees as $employee) {
                    $leave_types = $leave->getEmployeeLeaveBalance($employee->department_id, $employee->employee_id, $employee->campus_id, $start_sy, $end_sy);
                    if (!$leave_types) {
                        $datasets[] = [0,$employee->first_name . ' ' . $employee->last_name];
                        continue;
                    }
                    $leave_types[0] = $leave_types[0] + ['employee' => $employee->first_name . ' ' . $employee->last_name];
                    
                    $datasets[] = $leave_types;
                   
                }

                return json_encode($datasets);
            }
    }
}
