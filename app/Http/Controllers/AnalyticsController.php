<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\employee;
use App\Attendance;
use App\Schedule;
use App\Campus;
use Carbon\Carbon;
use DB;

class AnalyticsController extends Controller
{

    public function employee() {

        $campuses = Campus::all();
        return view('Analytics.employee', compact('campuses'));
    }

    public function export(Request $request) {

        $campus_id = $request->input('campus_id');
        $employees = employee::where(['campus_id' => $campus_id,'employment_type' => 'full_time'])->get();

        $startDate = Carbon::parse($request->input('from'));
        $toDate = Carbon::parse($request->input('to'));

        $this->datasets = [];

        foreach ($employees as $employee) {

            $campus_id = $employee->campus_id;
            $employee_id = $employee->employee_id;
            $scheduleStartTime = Carbon::parse(Schedule::where('id', $employee->schedule_id)->first()->start);

            $attendances = Attendance::orderBy('date','ASC')
            ->Where(['employee_id' => $employee_id, 'campus_id' => $campus_id])
            ->whereBetween(DB::raw("DATE_FORMAT(date,'%m/%d/%y')") , [$startDate->format('m/d/y'), $toDate->format('m/d/y')])->get()->toArray();

            $dates = $this->formatAttendance($attendances);

            foreach ($dates as $d) {
                $label = "no";

                $min = min(array_map('strtotime', $d));
                $timeIn = Carbon::createFromTimestamp($min);

                if ( Carbon::parse($timeIn->format('h:i'))->gt(Carbon::parse($scheduleStartTime)) ) {

                $label = "yes";
            }

            $this->datasets[] = array(
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'marital_status' => $employee->marital_status,
                'gender' => $employee->gender,
                'tardy' => $label
            );

        }

        $this->importToExcel($this->datasets);
        return "<script>window.close();</script>";
  }


}

public function importToExcel($datasets) {

    Excel::create('employees_dataset', function($excel) {

        $excel->sheet('Sheetname', function($sheet) {

            $sheet->fromArray($this->datasets);

        });

    })->export('xls');
    

}

public function formatAttendance($attendances) {

  $dates = [];

  foreach ($attendances as $attendance) {
     $date = Carbon::parse($attendance['date'])->format('m/d/Y');
     $dates[$date][] = $attendance['date'];
 }

 return $dates;
}


}
