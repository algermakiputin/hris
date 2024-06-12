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
}
