<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;	
use Illuminate\Notifications\Notifiable;

class Users extends \Eloquent implements Authenticatable, CanResetPasswordContract
{
    	use AuthenticableTrait,
     CanResetPassword,
     Notifiable;
     
    	protected $fillable = ['name', 'email', 'role', 'password','avatar','employee_id','active','campus_id'];

    	public function store($data){

    		return $this->create($data);
    	
    	}

    	public static function employmentType() {

    		if ($type = \App\employee::select('employment_type')->where('employee_id', Auth()->user()->employee_id)->first())
    			return $type->employment_type;

    		return false;

    	}
   
}

