<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Leave;
use App\employee;
use App\Campus;
use App\Department; 
use DB;
use App\Users;
use Carbon\Carbon;

class AppController extends Controller
{

    public function index() {
  	 
      	$year = date('Y');
		$applications = [];
		$approved = [];
		$disapprove = [];
		for ($i = 1; $i <= 12; $i++) {

			$count = Leave::where(DB::raw('DATE_FORMAT(created_at, "%m")'), '=' , $i)
						->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), '=' , $year)
						->count();

			$approve = Leave::where(DB::raw('DATE_FORMAT(created_at, "%m")'), '=' , $i)
						->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), '=' , $year)
						->where('status', 1)
						->count();
			$unapprove = Leave::where(DB::raw('DATE_FORMAT(created_at, "%m")'), '=' , $i)
						->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), '=' , $year)
						->where('status', 0)
						->where('pending', 0)
						->count();

			$approved[] = $approve;
			$applications[] = $count;
			$disapprove[] = $unapprove;

		}

        	$employeeCount = employee::count();
        	$departmentCount = Department::count();
        	$campusCount = Campus::count();
        	$pendingLeave = Leave::where(['status' => 0, 'pending' => 1])->count();
		
		return view('index',compact('applications','approved','disapprove','employeeCount','departmentCount','campusCount','pendingLeave'));
 
    }
}
