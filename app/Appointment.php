<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['campus_id', 'employee_id', 'date_time', 'reason', 'status', 'department_id'];  
}
