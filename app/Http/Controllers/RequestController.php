<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\requests;
use Illuminate\Support\Facades\DB;
use App\employee;
use App\admin_notifications;
use App\Users;
use App\Notification;

class RequestController extends Controller
{
    public function new() {
        return view('request.new');
    }

    public function store(Request $request) { 
        $admins = Users::where('employee_id', null)->get();
        requests::create([
            'employee_id' => Auth()->user()->employee_id,
            'type' => $request->type,
            'file' => '',
            'status' => 'pending'
        ]);

        foreach ($admins as $admin) {
            admin_notifications::create([
                "message" => "New File Request",
                "description" => Auth()->user()->name . " " . "has created a file request", 
                "link" => "admin/request",
                "admin_id" => $admin->id,
                "status" => 1
            ]);
        } 

        return redirect()->back();
    }

    public function index(Request $request) { 
        $requests = requests::where('employee_Id', Auth()->user()->employee_id)->get();
        return view('request.index', compact('requests'));
    }

    public function adminRequest() {
        $requests = requests::all();
        foreach ($requests as $request) {
            $employee = employee::where('employee_id', $request->employee_id)->first();
            $request->employeeName = $employee->first_name . ' ' . $employee->last_name;
        } 
        
        return view('request.admin-request', compact('requests'));
    }

    public function update(Request $request) { 
        $fileName = "";
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/file');
            $fileName = basename($path);   
        }

        $data = array(
            'status' => $request->input('status'),
            'file' => $fileName
        ); 
        requests::where('id', $request->input('id'))->update($data);
        $requestData = requests::find($request->input('id'));
        $employee = employee::where('employee_id', $requestData->employee_id)->first(); 
        Notification::create([
            'employee_id' => $employee->employee_id,
            'campus_id' => $employee->campus_id,
            'user_id' => $employee->id,
            'message' => "File Request " . $request->input('status'),
            'link' => "appointments",
            'status' => 1
        ]); 
        return redirect()->back();
    }

    public function uploadFile(Request $request) {
        $request->validate([
                'avatar' => 'required|mimes:jpg,jpeg,bmp,png'
            ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('public/file');
            $fileName = basename($path); 
            employee::where('employee_id', $request->input('_id'))->update(['avatar' => $fileName]);
            Users::where('employee_id', $request->input('_id'))->update(['avatar' => $fileName]);
            return redirect()->back()->with('success-upload', 'Avatar uploaded successfully');
        } 
    }
}
