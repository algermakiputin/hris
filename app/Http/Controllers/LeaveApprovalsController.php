<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveApproval;
use App\departmentHeads;
use App\Leave; 

class LeaveApprovalsController extends Controller
{
    
    public function insert(Request $request) {
    		$leave_id = $request->input('leave_id');
    		$data = [
    			'leave_id' => $leave_id,
    			'campus_id' => $request->input('campus_id'),
    			'employee_id' => $request->input('employee_id'),
    			'status' => $request->input('status'),
                'note' => $request->input('note')
    		];

    		if ($request->input('status') == 'approved') {
    			$leave = Leave::where('id', $leave_id)->first();
    			$heads = departmentHeads::where('department_id', $leave->department_id)->get();
    			$approvalCount = $heads->count();
    			$approvedCount = 0;
    		 
    			foreach ($heads as $head) {
    			 
    				$approval  = LeaveApproval::where(['leave_id' => $leave->id, 'campus_id' => $head->campus_id, 'employee_id' => $head->employee_id])->first();
    				 
    				if ($approval) {
    					if ($approval->status == "approved")
    						$approvedCount++;
    				}
    				
    			}

    			if ($approvedCount == ($approvalCount - 1)) {
    				LeaveApproval::create($data);
    				Leave::where('id', $leave->id)->update(['pending' => 0, 'status' => 1]);
                    return 'approved';
    			} 

    			LeaveApproval::create($data);
                return 'pending';
    		}
    		

    }
}
