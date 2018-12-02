<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id','employee_id','campus_id', 'message', 'link', 'status'];

    public function insert($user_id, $campus_id, $employee_id, $message, $link) {
    		return Notification::create([
			'employee_id' => $user_id,
			'campus_id' => $campus_id,
			'user_id' => $employee_id,
			'message' => $message,
			'link' => $link,
			'status' => 1
		]);
    }
}
