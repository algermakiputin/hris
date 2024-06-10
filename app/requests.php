<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class requests extends Model
{
    protected $fillable = ['employee_id', 'type', 'file', 'status'];
}
