<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\requests;

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
}
