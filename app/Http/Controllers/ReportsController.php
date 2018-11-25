<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Roles;
use App\Attendance;
use App\employee;
use Illuminate\Http\Request;


class ReportsController extends Controller
{
    public function general() {
    		$campuses = Campus::all();
    		$roles = Roles::all();
           
        	return view('Reports.general',compact('campuses','roles'));
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
                $start_sy = sy_start();
                $end_sy = sy_end();
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
