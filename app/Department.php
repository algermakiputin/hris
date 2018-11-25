<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

	protected $fillable = array('department_name', 'department_details', 'department_head');
    
    	public function getName($id) 
    	{
    		
    		return $this::find(intval($id)) ? $this->find($id)->name : 'Not Exist';
    		
    	}

    	public function deleteRow($id) 
    	{

    		return $this->where('id',$id)->delete();

    	}

    	public function department() 
    	{

    		return $this->belongsTo(Department::class);
    	}



}
