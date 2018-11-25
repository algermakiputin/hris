<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{

	public function getName($id) {
    		
    		return $this::find(intval($id)) ? $this->find($id)->name : 'Not Exist';
    	}

}
