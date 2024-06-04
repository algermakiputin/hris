<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index() {
        return view('Appointment.new');
    }

    public function new() {
        return view('Appointment.new');
    }
}
