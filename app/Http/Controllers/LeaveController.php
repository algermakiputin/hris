<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave_type;
use App\Leave;
use App\employee;
use App\departmentHeads;
use App\Campus;
use App\LeaveApproval;
use DB;
use App\Roles;
use App\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Session;

class LeaveController extends Controller
{

	public function index() {
		$sy = getCurrentSchoolYear();
	 	$sy_start = Carbon::create($sy['start'][0], $sy['start'][1])->format('Y-m-d');
	 	$sy_end = Carbon::create($sy['end'][0], $sy['end'][1])->format('Y-m-d');
	 	$school_year = $sy['sy'];
		$model = new Leave_type;
 
		if ($deptID = checkDepartmentHead()) {
			$status['application'] = Leave::whereBetween('date',[$sy_start, $sy_end])->where('department_id', $deptID)->count();
			$status['declined'] = Leave::where(['status' => 0, 'pending' => 0, 'department_id' => $deptID])->count();
			$status['approved'] = Leave::where(['status' => 1, 'pending' => 0, 'department_id' => $deptID])->count();
			$status['pending'] = Leave::where(['status' => 0, 'pending' => 1, 'department_id' => $deptID])->count();
		}else {
			$status['application'] = Leave::whereBetween('date',[$sy_start, $sy_end])->count();
			$status['declined'] = Leave::where(['status' => 0, 'pending' => 0])->count();
			$status['approved'] = Leave::where(['status' => 1, 'pending' => 0])->count();
			$status['pending'] = Leave::where(['status' => 0, 'pending' => 1])->count();
 		
		}
		
		$leaves = Leave::all();

		return view('Leave.index',compact('leaves','status','school_year'))->withModel($model);
	}

	public function calendar(Request $request) {
		return view('Leave.calendar');
	}

	public function getCalendar(Request $request) {

		$calendar = [];
		$date = $request->input('year') . $request->input('month');
		$leaves = Leave::where(DB::raw('DATE_FORMAT(date,"%Y%m")'), $date) 
			 		->where(['status' => 1, 'pending' => 0])
					->get();
		foreach ($leaves as $leave) {
			$employee = employee::where(['employee_id' => $leave->employee_id, 'campus_id' => $leave->campus_id])->first();

			if ($leave->duration == "short") {
				$start = $leave->date . ' ' . $leave->start;
				$end = $leave->date . ' ' . $leave->end;
				$start = Carbon::parse($start)->format('Y-m-d H:i:s');
				$end = Carbon::parse($end)->format('Y-m-d H:i:s');
			}else if ($leave->duration == "whole_day") {
				$start = $leave->date;
				$end = $leave->date;
			}else if ($leave->duration == "long") {
				$start = $leave->start;
				$end = $leave->end;
			}

			$calendar[] = array(
					'leave_id' => $leave->id,
					'employee_id' => $employee->employee_id,
					'campus_id' => $employee->campus_id,
					'title' => ' '. ucwords($employee->first_name) . ' ' . ucwords($employee->last_name),
					'start' => $start,
					'end' => $end,
					'description' => 'test',
					'duration' => $leave->duration

				);
		}

		return json_encode($calendar);
	}
 
	public function myLeave() {

		$employee = employee::select('employee_id','campus_id','department_id')
	 						->where(['employee_id' => Auth()->user()->employee_id, 'campus_id' => Auth()->user()->campus_id])
	 						->first();
		$department_id = $employee->department_id;
		$leave_types = $this->getEmployeeLeaveBalance($department_id, $employee->employee_id, $employee->campus_id);

		$status['application'] = Leave::where('employee_id',Auth()->user()->employee_id)->count();
		$status['declined'] = Leave::where('employee_id',Auth()->user()->employee_id)->where(['status' => 0, 'pending' => 0])->count();
		$status['approved'] = Leave::where('employee_id',Auth()->user()->employee_id)->where(['status' => 1, 'pending' => 0])->count();
		$status['pending'] = Leave::where('employee_id',Auth()->user()->employee_id)->where(['status' => 0, 'pending' => 1])->count();
		 
		return view('Leave.myLeaves',compact('status','leave_types'));

	}

	public function myLeaveBalance() {

		$leaveTypes = Leave_type::orderBy('id','DESC')->get(); 
		$employees = employee::where('employee_id', Auth()->user()->employee_id)->first();
		$dataSet = [];
		$types = [];
		$data = [];
		$name = $this->getName($employees->first_name, $employees->last_name);
		$types = $this->initLeaveTypes($leaveTypes);
		$id = $employees->employee_id;
		$leaves = Leave::where(['employee_id' => $id, 'status' => 1])->get();
		$dataSet[$id] = [];

		foreach ($leaves as $leave) {

			$start_date = Carbon::parse($leave->start_date);
			$end_date = Carbon::parse($leave->end_date);
			$days = $start_date->diffInDays($end_date);
			$leaveTypeName = Leave_type::where('id', $leave->leave_type_id)->first()->name;

			$types[$leaveTypeName][0]['count'] += $days;

		}

		$dataSet[$id][] = ['name' => $name,'leave_types' => $types];
		$data = $this->formatReports($dataSet);

		return view('Leave.balance',compact('data','leaveTypes'));
	}

	public function myLeaveDelete(Request $request) {

		return Leave::where(['id' => $request->input('id'), 'status' => 0, 'pending' => 1])->delete();

	}

	public function myLeaveData(Request $request) {
		$totalData = Leave::where('id',Auth()->user()->id)->count();
		$leaveType = new Leave_type;

		$limit = intval($request->input('length'));
		$start = intval($request->input('start'));
		$order = intval($request->input('order.0.column'));
		$dir = $request->input('order.0.dir');

		$col = $request->input("columns.$order.name");


		$leaves = Leave::offset($start)
					->limit($limit)
					->orderBy($col,$dir)
					->where(['employee_id' => Auth()->user()->employee_id, 'campus_id' => Auth()->user()->campus_id])
					->get();

		$totalFiltered = $leaves->count();
		$data = [];

		$counter = $start + 1;

		if ($leaves) {

			foreach ($leaves as $leave) {
				$dateFormat = "Y-m-d";
				if ($leave->duration == "short") {
					$from = $leave->start;
					$to = $leave->end;
				}else {
					$from = Carbon::parse($leave->start)->format($dateFormat);
					$to = Carbon::parse($leave->end)->format($dateFormat);
				}
				$nestedData = [
					ucfirst($leaveType->getLeaveType($leave->leave_type_id)),
					Carbon::parse($leave->date)->format($dateFormat), 
					$from, 
					$to, 
					$this->getStatus($leave->status, $leave->pending),
					'
					<a data-id="'.$leave->id.'" class="btn-success btn-link view" type="button" style="padding:3px 7px;border-radius:5px; " data-toggle="modal" data-target="#summary" data-id="'.$leave->id.'" data-employee="'.$leave->employee_id.'" data-campus="'.$leave->campus_id.'">View</a>
					'
				];

				$data[] = $nestedData;

			}
		}

		$jsonData = array(
			'draw' => $request->input('draw'),
			'recordsTotal' => intval($totalData),
			'recordsFiltered' => $totalData,
			'data' => $data

			);

		echo json_encode($jsonData);
	}

	public function summary(Request $request) {

		$datasets = [];
		$campus_id = $request->input('campus_id');
		$employee_id = $request->input('employee_id');
		$leave = Leave::find($request->input('id'));
		$employee = employee::where(['campus_id' => $campus_id, 'employee_id' => $employee_id])->first();
		$department_heads = departmentHeads::where('department_id', $leave->department_id)->orderBy('order','DESC')->get();
	  
		$needsApproval = false;
		 
	 	$leaveStatus = $this->getStatus($leave->status, $leave->pending);

		if ($department_heads->count()) {

			foreach($department_heads as $head) {

				$emp = employee::where(['employee_id' => $head->employee_id, 'campus_id' => $head->campus_id])->first();
				$row = LeaveApproval::where(['leave_id' => $leave->id, 'employee_id' => $emp->employee_id, 'campus_id' => $emp->campus_id])->first();
 		 	 
 				$status = "pending";
 				$note = "";
				if ($row) {
					$status = $row->status;
					$note = $row->note;
				}

				if ($status == "pending" && Auth()->user()->employee_id == $head->employee_id && Auth()->user()->campus_id == $head->campus_id && !$leave->status) {
					$needsApproval = true;
				}

				if ($status == "pending" && $leaveStatus == "declined" || $status == "approved" && $leaveStatus == "declined")
					$status = "closed";

				$head_employee[] = [
						'name' => ucfirst($emp->first_name) . ' ' . ucfirst($emp->last_name),
						'position' => (new Roles)->getName($emp->role_id), 
						'status' => $status,
						'note' => $note
					];
			}
		}else {
			$head_employee[] = null;
		}

		$start = Carbon::parse($leave->start);
		$end =  Carbon::parse($leave->end);

		if ($leave->duration == "whole_day") {
			$interval = '1 day';
			$duration = $start->format('Y-m-d');
		}else if ($leave->duration == "short") {
			$interval = Carbon::parse($leave->start)->diffInHours($leave->end) . ' Hours';
			$duration = $leave->date . ': ' . "$leave->start" . ' - ' . "$leave->end";
		}else if ($leave->duration == "long") {
			$interval = $start->diffInDays($end) . ' Days';
			$duration = $start->format('Y-m-d') . ' - ' . $end->format('Y-m-d');
		}

		$datasets['summary'][] = [
			'name' => ucfirst($employee->first_name) . ' ' . ucfirst($employee->last_name),
			'document' => $leave->document ? url('storage/document') . '/' . $leave->document : null,
			'reason' => $leave->reason,
			'leave_type' => (new Leave_type)->getLeaveType($leave->leave_type_id),
			'duration' => $duration,
			'interval' => $interval
			
		];

		$datasets['heads'][] = $head_employee;
		$datasets['needsApproval'] = $leaveStatus == "declined" ? false : $needsApproval;
		$datasets['campus_id'] = Auth()->user()->campus_id;
		$datasets['employee_id'] = Auth()->user()->employee_id;
		$datasets['leave_id'] = $leave->id;
		$datasets['status'] = $this->getStatus($leave->status, $leave->pending);

		return json_encode($datasets);
	}

	public function report() {
 		
 		$employees = employee::select('id','first_name','last_name')->where('status',1)->get();
 		$campuses = Campus::all();

		return view('Leave.report', compact('employees','campuses'));
	}

	public function formatLeaveBalance($leaveTypes,$employee_id) {

		$dataSet = [];

		foreach ($leaveTypes as $type) {
			
			$days = 0;
			$id = $type->id;

			$leaves = leave::where(['leave_type_id' => $type->id, 'employee_id' => $employee_id,'status' => 1, 'pending' => 0])->get()->toArray();

			 
			if ($leaves) {
				foreach ($leaves as $leave ) { 
					$days += Carbon::parse($leave['start_date'])->diffInDays(Carbon::parse($leave['end_date']));
					$dataSet[$id][] = [
						'days' => $days,
						'name' => $type->name,
						'allowance' => $type->allowance
					];
				}
				continue;
			}

			$dataSet[$id][] = [
				'days' => $days,
				'name' => $type->name,
				'allowance' => $type->allowance
			];

		}

		return $dataSet;
	}

	function getName($fname, $lname) {
		return ucwords($fname . ' ' . $lname);
	}

	public function initLeaveTypes($leaveTypes) {
		$types = [];
		foreach ($leaveTypes as $type) {

			$types[$type->name][] = ['count' => 0];

		}

		return $types;
	}

	public function formatReports($dataSet) {
		$format = [];
		$data = [];
		foreach ($dataSet as $d) {
			array_push($format, $d[0]['name']);
			foreach($d[0]['leave_types'] as $t) {
				array_push($format, $t[0]['count']);
			} 

			$data[] = $format;
			$format = [];
		}

		return $data;
	}

	public function application() { 
	 	$employee = employee::select('employee_id','campus_id','department_id')
	 						->where(['employee_id' => Auth()->user()->employee_id, 'campus_id' => Auth()->user()->campus_id])
	 						->first();
		$department_id = $employee->department_id;
		$leave_types = $this->getEmployeeLeaveBalance($department_id, $employee->employee_id, $employee->campus_id);

		return view('Leave.application',compact('leave_types','department_id'));

	}

	public function employeeReport(Request $request) {
		$employee = employee::find($request->input('id'));
		$empID = $employee->employee_id;
		$deptID = $employee->department_id;
		$campID = $employee->campus_id;

		$leave = $this->getEmployeeLeaveBalance($deptID, $empID, $campID);
		dd($leave);

	}

	public function generalReports(Request $request) {
		$totalData = employee::all()->count();
		$leaveType = new Leave_type;

		$limit = intval($request->input('length'));
		$start = intval($request->input('start'));  
		$sy = $request->input('columns.3.search.value'); 
		$search = $request->input('search.value');

		if ($search) {

			$employees = employee::offset($start)
				->limit($limit)
				->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%' . $search . '%')
				->get();
		}else {
			$employees = employee::offset($start)
				->limit($limit) 
				->get();
		}

		
		$start_sy = sy_start();
		$end_sy = sy_end();

		if ($sy) {
			$s = substr($sy, 0,2);
			$start = (int)substr($sy, 2,4);
			$end = $start + 1;
			$sy_start = config('config.school_year.start');
			$sy_end = config('config.school_year.end');
			$start_sy = Carbon::create($s ."$start", $sy_start)->format('Y-m-d');
			$end_sy = Carbon::create($s . "$end", $sy_end)->format('Y-m-d');
 
		}
 

		$totalFiltered = $employees->count();
		$data = [];

		$counter = $start + 1;

		if ($employees) {

			foreach ($employees as $employee) {
				
				$leave_types = $this->getEmployeeLeaveBalance($employee->department_id, $employee->employee_id, $employee->campus_id, $start_sy, $end_sy);

				if ($leave_types) {

					foreach ($leave_types as $type) {

						$nestedData = [
								ucfirst($employee->first_name) . ' ' . ucfirst($employee->last_name),
								$type['name'],
								$type['allowance'],
								$type['used'],
								$type['balance']
							];

						$data[] = $nestedData;

					}
				}
				
				

			}
		}

		$jsonData = array(
			'draw' => $request->input('draw'),
			'recordsTotal' => intval($totalData),
			'recordsFiltered' => $totalData,
			'data' => $data 

			);


		echo json_encode($jsonData);
	}

	public function getEmployeeLeaveBalance($deptID, $employee_id, $campus_id, $start = null, $end = null) {
		
		$department_id = $deptID;
		$leave_types = Leave_type::select('id','name','allowance')->where('department_id', $department_id)->get();
		
		$dataSets = [];
		//Get leave types allowance and used leave
		$x = count($leave_types); 
		
		foreach ($leave_types as $type) {
			$minutes = 0;	
			$allowance = $type->allowance;
			$leave_type_id = $type->id;
			
			//GET All Approve leaves from this employee
			$leaves = $this->getApproveLeaveFromLeaveType($leave_type_id, $employee_id, $campus_id, $start, $end);

			foreach ($leaves as $leave) {

				$minutes += $this->getTotalMinutes($leave);

			}

			$usedLeave = $this->getUsedLeave($minutes);
			$currentBalance = $this->getBalance($minutes, $allowance);
			$dataSets[] = [
				'id' => $type->id,
				'name' => $type->name,
				'allowance' => $allowance, 
				'used' => $usedLeave == "" ? 0 : $usedLeave,
				'balance' => $currentBalance == "" ? 0 : $currentBalance
			];

		}
	 
		return $dataSets;
	}

	public function getApproveLeaveFromLeaveType($leave_type_id, $employee_id, $campus_id, $start = null, $end = null) {
		
		$data = [
			'leave_type_id' => $leave_type_id, 
			'employee_id' => $employee_id, 
			'campus_id' => $campus_id, 
			'status' => 1, 
			'pending' => 0
		];

		if ($start && $end) 
			return Leave::whereBetween('date', [$start, $end])->where($data)->get();

		return Leave::where($data)->get();
	}

	public function getUsedLeave($minutes) {
		$used = "";
		if ($minutes >= 480) {
			$days = (int)floor(($minutes / 60) / 8);
			$hours = ($minutes / 60) % 8;
			$minutes = $minutes % 60;
			
			if ($days) 
				$used .= $days . ' Day' . $this->plural($days) . ' ';
			if ($hours) 
				$used .= $hours . ' Hour' . $this->plural($hours) . ' ';
			if ($minutes) 
				$used .= $minutes . ' Minute' . $this->plural($minutes) . ' ';
			return $used;
		}else if ($minutes < 480) {
			$hours = ($minutes / 60) % 8;
			$minutes = $minutes % 60;
			if ($hours) 
				$used .= $hours . ' Hour' . $this->plural($hours) . ' ';
			if ($minutes) 
				$used .= $minutes . ' Minute' . $this->plural($minutes) . ' ';
			return $used;
		}
	}

	public function getBalance($minutes, $allowance) {
		$balance = "";
		$allowanceInMinutes = ($allowance * 8) * 60;
		$balanceInMinutes = $allowanceInMinutes - $minutes;

		if ($balanceInMinutes >= 480) {
			$days = (int)floor(($balanceInMinutes / 60) / 8);
			$hours = ($balanceInMinutes / 60) % 8;
			$minutes = $balanceInMinutes % 60;
			if ($days) 
				$balance .= $days . ' Day' . $this->plural($days) . ' ';
			if ($hours) 
				$balance .= $hours . ' Hour' . $this->plural($hours) . ' ';
			if ($minutes) 
				$balance .= $minutes . ' Minute' . $this->plural($minutes) . ' ';
			return $balance;
		}else if ($balanceInMinutes < 480) {
			$hours = ($balanceInMinutes / 60) % 8;
			$minutes = $balanceInMinutes % 60;

			if ($hours) 
				$balance .= $hours . ' Hour' . $this->plural($hours) . ' ';
			if ($minutes) 
				$balance .= $minutes . ' Minute' . $this->plural($minutes) . ' ';
			return $balance;
		}
	}

	public function plural($i) {
		if ($i > 1) 
			return 's';
	}

	

	public function getTotalMinutes($leave) {

		$minutes = 0;

		if ($leave->duration == "whole_day") {

			$minutes = 8 * 60;
		}else if ($leave->duration == "short") {
			$start = Carbon::parse($leave->start);
			$end = Carbon::parse($leave->end);
			$minutes = $start->diffInMinutes($end);


		}else if ($leave->duration == "long") {
			$start = Carbon::parse($leave->start);
			$end = Carbon::parse($leave->end);
			$diff = $start->diffInDays($end);
			$minutes = ($diff * 8) * 60;
		}

		return $minutes;
	}

	public function setting() {

		return view('Leave.setting');
	}

	public function insert(Request $request) {
 		$request->validate([
					'leave_type' => 'required',
					'duration' => 'required',
					'reason' => 'required'
				]);

		$duration = $request->input('duration');
		
		if ($duration == "short") {
			$start = $request->input('start_time');
			$end = $request->input('end_time');
			$date = $request->input('leave_date');
			$request->validate([
					'start_time' => 'required',
					'end_time' => 'required',
					'leave_date' => 'required'
				]);

		}else if ($duration == "whole_day") {
			$start = $request->input('date');
			$end = $request->input('date');
			$date = $request->input('date');
			$request->validate([
					'date' => 'required' 
				]);

		}else if ($duration == "long") {
			$date = date('Y-m-d', strtotime($request->input('start_date')));
			$start = $request->input('start_date');
			$end = $request->input('end_date');
			$request->validate([
					'start_date' => 'required',
					'end_date' => 'required'  
				]);
		}
 
		if ($request->hasFile('document')) {
			$request->validate([
					'document' => 'mimes:txt,jpeg,pdf,docx'
				]);
			$path = $request->file('document')->store('public/document');
            	$fileName = basename($path);
		}else {
			$fileName = null;
		}

		$leave = new Leave;
		$leave->leave_type_id = $request->input('leave_type');
		$leave->employee_id = Auth()->user()->employee_id;
		$leave->campus_id = Auth()->user()->campus_id;
		$leave->reason = $request->input('reason');
		$leave->duration = $request->input('duration'); 
		$leave->date = $date;
		$leave->start = $start;
		$leave->end = $end;
		$leave->document = $fileName;
		$leave->status = 0;
		$leave->pending = 1; 
		$leave->department_id = $request->input('department_id');

		if ($leave->save()) {
			return redirect()->back()->with('success','Your application has been submitted successfully');
		}
	}

	public function approve(Request $request, Leave $leave) {
		$id = $request->input('id');

		if ($leave->approve($id)) 
			return redirect()->back();

	}

	public function decline(Request $request) {
		
	 	return LeaveApproval::create([
				'leave_id' => $request->input('leave_id'),
				'campus_id' => $request->input('campus_id'),
				'employee_id' => $request->input('employee_id'), 
				'status' => $request->input('status'),
				'note' => $request->input('reason')
			]); 


	}

	public function data(Request $request) {

		$totalData = Leave::count();
		$leaveType = new Leave_type;
		$limit = intval($request->input('length'));
		$start = intval($request->input('start'));
		$order = intval($request->input('order.0.column'));
		$dir = $request->input('order.0.dir');
		$col = $request->input("columns.$order.name");
		$search = $request->input('search.value');
		$sy = getCurrentSchoolYear();

		if (checkDepartmentHead()) {
			 $leaves = Leave::offset($start)
					->limit($limit)
					->orderBy($col,$dir)
					->whereIn('department_id', checkDepartmentHead())
					->get();
		}else {
			$leaves = Leave::offset($start)
					->limit($limit)
					->orderBy($col,$dir)
					->get();
		}



		$totalFiltered = $leaves->count();
		$data = [];

		if ($leaves) {

			foreach ($leaves as $leave) {
				$employee = employee::where(['campus_id' => $leave->campus_id, 'employee_id' => $leave->employee_id])->first();
				$dateFormat = "Y-m-d";
				$nestedData = [
					Carbon::parse($leave->date)->format($dateFormat),
					ucfirst($employee->first_name) . ' ' . ucfirst($employee->last_name),
					ucfirst($leaveType->getLeaveType($leave->leave_type_id)),
					Carbon::parse($leave->start)->format($dateFormat), 
					Carbon::parse($leave->end)->format($dateFormat), 
					$this->getStatus($leave->status, $leave->pending),
					'
						<a data-id="'.$leave->id.'" class="btn-success btn-link view" type="button" style="padding:3px 7px;border-radius:5px; " data-toggle="modal" data-target="#summary" data-id="'.$leave->id.'" data-employee="'.$leave->employee_id.'" data-campus="'.$leave->campus_id.'">View</a>

					'
				];

				$data[] = $nestedData;

			}
		}

			$jsonData = array(
				'draw' => $request->input('draw'),
				'recordsTotal' => intval($totalData),
				'recordsFiltered' => $totalData,
				'data' => $data

				);


			echo json_encode($jsonData);

		}

		public function getStatus($status, $pending) {

			if ($pending == 1 && $status == 0) 
				return "Pending";
			else if ($pending == 0 && $status == 1) 
				return "Approved";
			else if ($pending == 0 && $status == 0) 
				return "Declined";

		}


	}
