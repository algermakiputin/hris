<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model

{
	protected $fillable = ['employee_id', 'campus_id', 'date', 'name'];   
}
