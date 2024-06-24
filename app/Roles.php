<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = ['name','description', 'department_id'];

    public function getName($id) {

    		return $this->where('id', $id)->first()->name;
    }
 
}
