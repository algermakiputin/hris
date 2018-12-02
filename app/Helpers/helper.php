<?php 
	use App\Notification;
	use App\employee;
	use Carbon\Carbon;

	function checkDepartmentHead() {

		$departmentHeads = Session::get('heads');

		if ($departmentHeads) {
			$userCampusID = Auth()->user()->campus_id;
			$userEmployeeID = Auth()->user()->employee_id;
			$department = [];
			foreach ($departmentHeads as $head) {
	
				if ($head['campus_id'] == $userCampusID && $head['employee_id'] == $userEmployeeID) {
					$department[] = $head['department_id'];
				}

			}
			
			if ($department) {
				//Return The Department ID
				return $department;
			}
		}

		return [];

	}

	function getCurrentSchoolYear() {
		$school_year = config('config.school_year');

    		$year = date('y');

    		$m = date('m');
    		$currentYear = substr(date('Y'), 0,2);

    	 
 		$sy_start = $school_year['start'];
 		$sy_end = $school_year['end'];


 		if ($m  < (int)$sy_end)  
 		 	return [
 		 		'start' => [$currentYear . ($year - 1), $sy_start],
 		 		'end' => [$currentYear . $year, $sy_end],
 		 		'sy' => $currentYear . ($year - 1) . ' - ' . $currentYear . $year
 		 	];
 	
 		return  [
	 		'start' => [$currentYear . $year, $sy_start],
	 		'end' => [$currentYear . ($year + 1), $sy_end],
	 		'sy' =>  $currentYear . $year . ' - ' . $currentYear . ($year + 1)
	 	];	
 	}

 	function scheduleExist($day, $time, $scheds) {

 		foreach ($scheds as $sched) {

 			if ($sched['day'] !== $day)
 				continue;
 			else 
 				return $sched[$time];

 		}

 		return false;

 	}

 	function toTime($time) {
 		return date('h:i a', strtotime($time));
 	}

 	function sy_start() {
 		$sy = getCurrentSchoolYear();
 		return $sy['start'][0] . '-' . $sy['start'][1] . '-1';
 	}

 	function sy_end() {
 		$sy = getCurrentSchoolYear();
 		return $sy['end'][0] . '-' . $sy['end'][1] . '-1';
 	}

 	function getNotification() {
 		$datasets = [];
 		$notification = Notification::where(['employee_id' => Auth()->user()->employee_id,
 										'campus_id' => Auth()->user()->campus_id,
 										'status' => 1
 							])->get();
 		if ($notification) {

 			foreach ($notification as $notify) {
 				$employee = employee::find($notify->user_id);
 				$name = ucwords($employee->first_name . ' ' . $employee->last_name);


 				$datasets[] = [
 					'id' => $notify->id,
 					'avatar' => $employee->avatar,
 					'diff' => Carbon::parse($notify->created_at)->diffForHumans(),
 					'message' => $name . ' ' . $notify->message,
 					'link' =>  $notify->link,
 					'name' => $name
 				];

 			} 
 		
 		}

 		return $datasets;


 	}


?>