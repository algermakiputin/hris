<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParttimeSchedule;
use Carbon\Carbon;

class ParttimeScheduleController extends Controller
{

    public function destroy(Request $request) {
        ParttimeSchedule::where('id', $request->input('id'))->delete();
        return redirect()->back()->with('success', 'Schedule Deleted successfully')
                                ->with('update', 'schedule');
    }

    public function insert(Request $request) {
        $startTime = Carbon::parse($request->input('start_time'))->format('G:i:s');
        $endTime = Carbon::parse($request->input('end_time'))->format('G:i:s');
        $empID = $request->input('employee_id');
        $campusID = $request->input('campus_id');
        $sched = [
                'day' => $request->input('day'),
                'start' => $startTime,
                'end' => $endTime,
                'employee_id' => $empID,
                'campus_id' => $campusID
            ];

        $validate = ParttimeSchedule::where('start', '>=', $startTime)
                                    ->where('end', '<=', $endTime)
                                    ->where('employee_id', $request->input('employee_id'))
                                    ->where('campus_id', $campusID)
                                    ->count();    

        if (!$validate) {
            ParttimeSchedule::create($sched);
            return redirect()->back()->with('update','schedule')
                                    ->with('success', 'Schedule added successfully');
        }

        return redirect()->back()->with('error','error')
                                ->with('update', 'schedule');

    }
    
    public function update(Request $request) {
       
		$scheds = array(
				$request->input('mon'),
			$request->input('tue'),
			$request->input('wed'),
			$request->input('thu'),
			$request->input('fri'),
			$request->input('sat'),
			$request->input('sun')
			);

        $set = (int)$request->input('set');
		$campus_id = $request->input('campus_id');
        $employee_id = $request->input('employee_id');

		foreach ($scheds as $key => $sched) {

			if ($sched[0] && $sched[1]) {
				$day = $key + 1;

          
                if ($set) {
                    $exist = ParttimeSchedule::where([
                                                'campus_id' => $campus_id, 
                                                'employee_id' => $employee_id, 
                                                'day' => $day])
                                            ->count();
                    if ($exist) {
                        ParttimeSchedule::where([
                                        'campus_id' => $campus_id, 
                                        'employee_id' => $employee_id, 
                                        'day' => $day])
                                        ->update([
                                            'start' => Carbon::parse($sched[0])->format('G:i'), 
                                            'end' => Carbon::parse($sched[1])->format('G:i')]);
                    }else {
                        ParttimeSchedule::create([
                            'day' => $day,
                            'start' => Carbon::parse($sched[0])->format('G:i'),
                            'end' => Carbon::parse($sched[1])->format('G:i'),
                            'campus_id' => $request->input('campus_id'),
                            'employee_id' => $request->input('employee_id')
                        ]);
                    }
                    
                }else {
                    ParttimeSchedule::create([
                        'day' => $day,
                        'start' => Carbon::parse($sched[0])->format('G:i'),
                        'end' => Carbon::parse($sched[1])->format('G:i'),
                        'campus_id' => $request->input('campus_id'),
                        'employee_id' => $request->input('employee_id')
                    ]);
                }
				
			} 

		}

        return redirect()->back()->with('update','schedule');


    }
}
