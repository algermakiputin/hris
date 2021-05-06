<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Calendar;

use DB;

class CalendarController extends Controller
{
    
    public function calendar() {
        $events = array();
        $data = Calendar::select('title','start','description','id','type')->get()->toArray();
        $bg = '';
       
        foreach ($data as $d){
            if ($d['type'] == 'event') 
                $bg = "#26B99A";
            else 
                $bg = "#3a87ad";
            
            $events[] = array(
                    'title' => $d['title'],
                    'start' => date('Y') . date('-m-d',strtotime($d['start'])),
                    'description' => $d['description'],
                    'id' => $d['id'],
                    'type' => $d['type'], 
                    'color' => $bg
                );
            
        }
    	return view('Events.Calendar',compact('events'));
    	
    }

    public function events(Request $request) {
        $year = $request->input('year');
        $calender = Calendar::where(DB::raw('DATE_FORMAT(start,"%m")'), $request->input('month'))->get();
        
        return json_encode($this->groupEvents($calender,$year));
    }

    public function groupEvents($calender,$year) {
        
        $events = [];
        
        foreach ($calender as $e) {

            $events[$e->type][] = $e;

            if ($e->type == 'event') 
                $bg = "#26B99A";
            else 
                $bg = "#3a87ad";
            
            $events['calendar'][] = array(
                    'title' => $e->title,
                    'start' => $year . date('-m-d',strtotime($e->start)),
                    'description' => $e->description,
                    'id' => $e->id,
                    'type' => $e->type, 
                    'color' => $bg
                );
        }

        return $events;

    }

    public function store(Request $request) {

    		return Calendar::create([
    				'title' => $request->input('title'),
    				'description' => $request->input('description'),
    				'start' => $request->input('date'),
    				'type' => $request->input('type')
    			]);
    }

    public function update(Request $request) {

        return Calendar::where('id', $request->input('id'))->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'), 
                'type' => $request->input('type')
            ]);
    }

    public function destroy(Request $request) {

        return Calendar::where('id', $request->input('id'))->delete();
    }
}
