<?php

namespace App\Http\Controllers;
use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function viewed(Request $request) {
    		$id = $request->input('id');
    		return Notification::where('id', $id)->update(['status' => 0]);


    }
}
