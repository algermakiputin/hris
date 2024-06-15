<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin_notifications extends Model
{
    protected $fillable = ["message", "link", "status", "admin_id", "description"];
}
