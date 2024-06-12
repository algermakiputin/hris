<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\requests;
use Illuminate\Support\Facades\DB;
use App\employee;

class RequestController extends Controller
{
    public function new() {
        return view('request.new');
    }

    public function store(Request $request) {
        requests::create([
            'employee_id' => Auth()->user()->employee_id,
            'type' => $request->type,
            'file' => '',
            'status' => 'pending'
        ]);
        return redirect()->back();
    }

    public function index(Request $request) {
        $requests = requests::all();
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
      
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/file');
            $fileName = basename($path);
            $data = array(
                'status' => $request->input('status'),
                'file' => $fileName
            );

            requests::where('id', $request->input('id'))->update($data);
            return redirect()->back();

        }
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
