<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class departmentHeads extends Model
{
    protected $fillable = ['department_id', 'employee_id','order','campus_id'];
}
