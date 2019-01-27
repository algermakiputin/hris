<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	protected $fillable = ['day','start','end','employee_id','campus_id'];
}
