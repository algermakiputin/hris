<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    	protected $primary_key = 'id';

    	public function destroyRow($id) {

    		$this->where('id', $id)->delete();

    	}

    	public function getName($id) {

    		$employee = $this::select(['first_name','last_name'])->where('employee_id', $id)->first();
    		return $employee->first_name . ' ' . $employee->last_name;
    	}

    	public function store($request,$resume) {
		$this->first_name = $request['first_name'];
		$this->last_name = $request['family_name'];
		$this->middle_name = $request['middle_initial'];
		$this->employee_id = $request['employee_id'];
		$this->gender = $request['gender'];
		$this->birthday = $request['birthday'];
		$this->email_address = $request['email_address'];
		$this->mobile = $request['mobile'];
		$this->telephone = $request['telephone'];
		$this->marital_status = $request['marital_status'];
		$this->role_id = $request['designation'];
		$this->campus_id = $request['campus'];
		$this->department_id = $request['department'];
		$this->employment_type = $request['employment_type'];
		$this->salary = $request['salary'];
		$this->date_joining = $request['date_joining'];
		$this->resume = $resume; 
		$this->status = $request['status'];
		$this->schedule_id = $request['schedule'] ?? 0;
		$this->tenure = $request['tenure'];
		$this->education = $request['education'];

		$this->save();
		return $this->id;
    	}

    	public function update_personal_details($request) {

    		$update = $this->where('id', $request['_id'])->update([
    				'first_name' => $request['first_name'],
				'last_name' => $request['last_name'],
				'middle_name' => $request['middle_name'], 
				'gender' => $request['gender'],
				'birthday' => $request['birthday'],
				'email_address' => $request['email'],
				'mobile' => $request['mobile'],
				'telephone' => $request['telephone'],
				'marital_status' => $request['marital_status'],
				'education' => $request['education']
    			]);
    		
		return $update;
    	}

    	public function update_employment_details($request) {
  	 
    		$data = array(
    				'campus_id' => $request['campus_id'],
    				'role_id' => $request['designation'],
    				'employment_type' => $request['employment_type'],
    				'department_id' => $request['department'],
    				'salary' => $request['salary'],
    				'date_joining' => $request['date_joining'],
    				'status' => $request['status'],
    				'schedule_id' => $request['schedule'],
    				'tenure' => $request['tenure']
    			);

    		return $this->where('id', $request['_id'])->update($data);

    	}

    	public function getID() {
    		$employee_id = $this->where(['employee_id' => Auth()->user()->employee_id,
    								'campus_id' => Auth()->user()->campus_id
    							])->first();
    		return $employee_id->id;
    	}

}
