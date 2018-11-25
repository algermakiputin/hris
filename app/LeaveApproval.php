<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{
    protected $fillable = ['leave_id','campus_id','employee_id','status','note'];
}
