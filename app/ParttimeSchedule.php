<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParttimeSchedule extends Model
{
	protected $fillable = ['day','start','end','employee_id','campus_id'];
}
