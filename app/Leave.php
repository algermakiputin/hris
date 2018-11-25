<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{

	protected $fillable = ['leave_type_id', 'employee_id', 'campus_id', 'reason', 'duration', 'date', 'start', 'end', 'document', 'status', 'pending', 'department_id'];
    
    public function approve($id) {

    		return $this->where('id',$id)->update(['status' => 1,'pending' => 0]);

    }

    public function decline($id,$reason) {
    	 
    		return $this->where('id',$id)->update(['status' => 0, 'pending' => 0,'decline_reason' => $reason]);
    }
}
