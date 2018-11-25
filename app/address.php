<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $fillable = ['address','employee_id','city','zipcode','state'];
}
