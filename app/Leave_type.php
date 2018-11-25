<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_type extends Model
{
	protected $fillable = array('name', 'description','allowance','department_id','campus_id');
	 
    	public function getLeaveType($id) {
    		if (is_numeric($id))
    			return $this::find($id)->name;
    	}
}
