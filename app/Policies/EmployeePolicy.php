<?php

namespace App\Policies;

use App\Users;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\employee;
use Illuminate\Http\Request;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function show(Users $user, $employee) {

        if (Auth()->user()->role) {

            return 1;

        }

        if ($user->employee_id == $employee->employee_id) {

            return $user->employee_id == $employee->employee_id;
         }

       

        abort(404);
         
    }

    public function edit(Users $user, $employee) {

        if (Auth()->user()->role) {

            return 1;

        }
         
        if (Auth()->user()->role == "staff") {

            if ($user->employee_id == $employee->employee_id) {

                return $user->employee_id == $employee->employee_id;
            }

        }
        
        abort(404);
         
    }

    

}
