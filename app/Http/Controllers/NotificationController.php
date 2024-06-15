<?php

namespace App\Http\Controllers;
use App\Notification;
use App\admin_notifications;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function viewed(Request $request) {
    		$id = $request->input('id');
            admin_notifications::where('id', $id)->update(['status' => 0]);
    		return Notification::where('id', $id)->update(['status' => 0]);
    }
}
