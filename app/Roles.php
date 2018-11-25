<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = ['name','description'];

    public function getName($id) {

    		return $this->where('id', $id)->first()->name;
    }
 
}
