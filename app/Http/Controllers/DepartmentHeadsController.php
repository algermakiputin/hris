<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\departmentHeads;
use App\employee;
use App\Roles;
use DB;

class DepartmentHeadsController extends Controller
{

	public function getEmployees(Request $request) {
 		$ids = [];
 		$campusID = [];

		if ($request->input('current')) {

			foreach ($request->input('current') as $cur) {

				$ids[] = $cur[0];
				$campusID = $cur[1];
			}

			$employees = employee::whereNotIn('employee_id', $ids) 
							->get();

		}else {
			 $employees = employee::whereNotIn('employee_id', $ids) 
							->get();
		}

		return json_encode($employees);

	}

	public function insert(Request $request) {

		return departmentHeads::create([
				'employee_id' => $request->input('employee_id'),
				'department_id' => $request->input('department_id'),
				'order' => $request->input('order'),
				'campus_id' => $request->input('campus_id')
			]);
	}

	public function get(Request $request) {
	 
		$employees = [];
		$heads = departmentHeads::where('department_id', $request->input('department_id'))
							->orderBy('order','ASC')
							->get();

		foreach ($heads as $head) {
			$employee = employee::where(['employee_id' => $head->employee_id, 'campus_id' => $head->campus_id])->first();
			
			$employees[] = array(
					'first_name' => ucfirst($employee->first_name),
					'last_name' => ucfirst($employee->last_name),
					'employee_id' => $employee->employee_id,
					'campus_id' => $employee->campus_id,
					'role' => ucwords((new Roles)->getName($employee->role_id)),
					'department_id' => $head->department_id
				);
		} 

		echo json_encode($employees);
	}

	public function destroy(Request $request) {
	 
		$data = [
			'employee_id' => $request->input('employee_id'), 
			'campus_id' => $request->input('campus_id') 
			];
 
		return departmentHeads::where($data)->delete();
	}

	public function order(Request $request) {
		$order = $request->input('order');
		$start = 1;


		foreach ($order as $ord) {

			departmentHeads::where(['employee_id' => $ord[0], 'campus_id' => $ord[1]])->update(['order' => $start]);
			$start++;

		}
		

	}
}
