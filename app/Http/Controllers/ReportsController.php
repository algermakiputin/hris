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

    public function recruitment() {
        $employees = employee::all();
        $count = 10;
        $current_year = date('Y');
        $years = [];
        $data = [];
        for ($i = 0; $i <= 9; $i++) {
            $year = (string)((int)$current_year - $i);
            array_push($years, $year);
            $data[$year] = 0;
        } 
        $sexReports = $this->getSexReports($employees);
        $ageReports = $this->getAgeReports($employees);
        $employmentStatusReports = $this->getEmploymentStatusReports($employees); 
        $academicRankReports = $this->getAcademicRankReports($employees);
       
        $date = "2023-10-10"; 
        foreach ($employees as $employee) {
            $joiningYear = date('Y', strtotime($employee->date_joining));
            if (in_array($joiningYear, $years)) {
                $data[$joiningYear] += 1;
            }
        } 
        
        $sexReportsLabel = json_encode(array_Keys($sexReports));
        $sexReportsData = json_encode(array_values($sexReports));
        return view('Reports.recruitment', compact(
            'data', 
            'sexReports', 
            'ageReports', 
            'employmentStatusReports', 
            'academicRankReports'
        ));
    }

    public function getAcademicRankReports($employees) {
        $data = [];
        foreach ($employees as $employee) {
            if (!$employee->academic_rank) continue;
            if (array_key_exists($employee->academic_rank, $data)) {
                $data[strval($employee->academic_rank)]++;
            } else {
                $data[strval($employee->academic_rank)] = 1;
            }
        }
        return $data;
    }

    public function getSexReports($employees) {
        $female = 0;
        $male = 0; 
        foreach ($employees as $employee) {
            if ($employee->gender) {
                $male++;
            } else {
                $female++;
            }
        }
        return array(
            'female' => $female,
            'male' => $male
        );
    }

    public function getAgeReports($employees) {
        $data = array(
            '19-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56-65' => 0,
            '66-75' => 0
        );
        $currentDate = Carbon::now();
        foreach ($employees as $employee) {
            $age = $currentDate->diffInYears($employee->birthday);
            if ($age >= 19 && $age <= 25) {
                $data['19-25']++;
            } else if ($age >= 26 && $age <= 35) {
                $data['26-35']++;
            } else if ($age >= 36 && $age <= 45) {
                $data['36-45']++;
            } else if ($age >= 46 && $age <= 55) {
                $data['46-55']++;
            } else if ($age >= 26 && $age <= 35) {
                $data['56-65']++;
            } else if ($age >= 66 && $age <= 75) {
                $data['66-75']++;
            }
        }  
        return $data;
    }

    public function getEmploymentStatusReports($employees) {
        $data = array(
            'Project Based' => 0,
            'Contractual' => 0,
            'Permanent' => 0,
            'Provisionary' => 0,
            'Part Time' => 0,
        ); 
        foreach ($employees as $employee) {
            if (array_key_exists($employee->employment_status, $data)) { 
                $data[$employee->employment_status] = $data[$employee->employment_status] + 1;
            }  
        }
     
        return $data;
    } 

    public function employees() {
        $employees = employee::all();
        return view('Reports.employees');
    }

    public function datatable(Request $request) {
        $draw = $request->input('draw');
        $limit = $request->input('length');
		$start = $request->input('start');
        $columnMapping = [
            'gender' => 'gender',
            'employment_type' => ''
        ];

        $column = $request->input('columns.0.search.value');
        $value = $request->input('columns.1.search.value');
        $order = $request->input('order.0.dir');
        $employees = [];
        $count = 0;
        if ($column == "gender") {
            $employees = employee::where($columnMapping[$column], $value)
                            ->offset($start)
                            ->limit($limit)
                            ->get();
            $count = employee::where($columnMapping[$column], $value)
            ->offset($start)
            ->limit($limit)
            ->count();
        } else if ($column == "birthday") {
            $ageMapping = array(
                '20-30' => [strtotime('-20 years', time()), strtotime('-30 years', time())],
                '31-40' => [strtotime('-31 years', time()), strtotime('-40 years', time())],
                '41-50' => [strtotime('-41 years', time()), strtotime('-50 years', time())],
                '51-60' => [strtotime('-51 years', time()), strtotime('-60 years', time())],
                '61+' => [strtotime('-61 years', time()), strtotime('-900 years', time())]
            );
            $from = date('Y-m-d', $ageMapping[$value][1]);
            $to = date('Y-m-d', $ageMapping[$value][0]);
           
            $employees = employee::whereBetween('birthday', [$from, $to]) 
                                ->offset($start)
                                ->limit($limit)
                                ->get();
            $count = employee::whereBetween('birthday', [$from, $to]) 
                                ->offset($start)
                                ->limit($limit)
                                ->count();
         
        } else if ($column == "employment_type") {
            $employees = employee::where('employment_status', $value)
                            ->offset($start)
                            ->limit($limit)
                            ->get();
            $count = employee::where('employment_status', $value)
                            ->offset($start)
                            ->limit($limit)
                            ->count();
        } else if ($column == "date_joining") {
            $dateJoiningMapping = array(
                'less' => [strtotime('-1 year', time()), time()],
                '1-5' => [strtotime('-13 month', time()), strtotime('-5 year', time())],
                '6-10' => [strtotime('-6 year', time()), strtotime('-10 year', time())],
                '11-20' => [strtotime('-11 year', time()), strtotime('-20 year', time())],
                '20+' => [strtotime('-21 year', time()), strtotime('-100 year', time())]
            );

            $from = date('Y-m-d', $dateJoiningMapping[$value][1]);
            $to = date('Y-m-d', $dateJoiningMapping[$value][0]);
           
            $employees = employee::whereBetween('date_joining', [$from, $to]) 
                                ->offset($start)
                                ->limit($limit)
                                ->get();
            $count = employee::whereBetween('date_joining', [$from, $to]) 
                                ->offset($start)
                                ->limit($limit)
                                ->count();
        }
 
        
        
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
