<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Http\Request;
use App\employee;
use Session;
use Excel;
use File;
use App\Leave;
use DB;
use App\Leave_type;
use App\Calendar;
use App\Campus;
use App\Schedule;
use App\ParttimeSchedule;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class AttendanceController extends Controller
{

	public function index() {
		$employees = employee::where('status', 1)->get();
		return view('Attendance.index',compact('employees'));
	}

	public function entry() {
		$campuses = Campus::all();
		return view('Attendance.entry', compact('campuses'));
	}

	public function insert(Request $request) {

		Attendance::create([
			'employee_id' => $request->employee,
			'campus_id' => $request->campus,
			'date' => Carbon::parse($request->date . ' ' . $request->timein), 
		]);

		Attendance::create([
			'employee_id' => $request->employee,
			'campus_id' => $request->campus,
			'date' => Carbon::parse($request->date . ' ' . $request->timeout),
			'name' => 'null',
		]);

		return redirect()->back()->with('success','Attendance saved successfully.');
	}

	public function upload() {
		$campuses = Campus::get();
		return view('Attendance.upload',compact('campuses'));

	}

	public function getAttendance($attendances) {
		$days = [];
		$worked = [];

		foreach($attendances as $a) {
			$date = Carbon::parse($a['date'])->format('m/d/Y');
			if(!in_array($date, $worked))
				$worked[] = $date;


			$days[$date][] = [
				'date' => $a['date'], 
			];
		}
		$attendance['attendance'][] = $days;
		$attendance['worked'][] = $worked;

		return $attendance;

	}

	public function getLeaves($leaves) {
		$dates = [];

		if ($leaves) {
			foreach ($leaves as $l) {
				$start_date = Carbon::parse($l->start_date);
				$end_date = Carbon::parse($l->end_date);
				$type = Leave_type::select('name')->where('id', $l->leave_type_id)->first()->name;
				for ($i = $start_date; $i->lte($end_date); $i->addDay()) {

					$dates['attendance'][] = $i->format('m/d/Y');
					$dates['type'][] = $type;
				}

			}

			return $dates;
		}

		return null;
	}

	public function getHolidays() {
		$dates = [];

		$holidays = Calendar::select('start')->where('type','holiday')->get()->toArray();

		foreach ($holidays as $holiday) {

			$dates[] = Carbon::parse($holiday['start'])->format('m/d/') . date('Y');
		}

		return $dates;
	}

	public function export(Request $request) {
		$data = $this->report($request);
		$data = json_decode($data,true);

		Excel::create('Filename', function($excel) use($data, $request) {

		    // Set the title
			$excel->setTitle('Our new awesome title');

		    // Chain the setters
			$excel->setCreator('Maatwebsite')
			->setCompany('Maatwebsite');

		    // Call them separately
			$excel->setDescription('A demonstration to change the file properties');
			$excel->sheet('Attendance Report', function($sheet) use($data, $request) {
				$dataset = [];

				foreach ($data['data'] as $d) {
					$dataset[] = array(
						'Date' => $d['date'] ?? '--', 
						'In' => $d['in'] ?? '--',
						'Out' => $d['out'] ?? '--',
						'Total Hours' => $d['total_hours'] ?? '--',
						'Late' => $d['late'] ?? '--',
						'Overtime' => $d['overtime'] ?? '--',
						'Status' => $d['status'] ?? '--',
					);
				}



				$sheet->fromArray($dataset);

				$sheet->prependRow(1, 
					array('Attendance Report')
				);
				$sheet->prependRow(2, 
					array("Date:", Carbon::parse($request->input('start_date'))->format('Y-m-d') . ' - ' . Carbon::parse($request->input('end_date'))->format('Y-m-d'))
				);
				$sheet->prependRow(3, 
					array('Employee Name:', $data['name'])
				);
				$sheet->prependRow(4, 
					array('Total Hours Worked:', $data['total_hours'])
				);
				$sheet->prependRow(5, 
					array('Total Late:', $data['late'])
				);
				$sheet->prependRow(6, 
					array('Total Overtime:', $data['overtime'])
				);

				$sheet->setWidth(array(
					'A'     =>  25,
					'B'     =>  25,
					'C'	=> 25,
					'D'	=> 15,
					'E'	=> 15,
					'F'	=> 15,
					'G'	=> 15
				));

				$sheet->setFontSize(14);
				$sheet->setFontBold(false);
				$sheet->prependRow(7, 
					array('')
				);
				$sheet->prependRow(8, 
					array('Attendance')
				);

				$sheet->setHeight(1, 25);

				$sheet->mergeCells('A1:G1');
				$sheet->cell('A1', function($cell) {

					$cell->setAlignment('center');
					$cell->setValignment('center');
					$cell->setFontSize(18);
					$cell->setFontWeight('bold');
					$cell->setBackground('#00238b');
					$cell->setFontColor('#ffffff');

				});
				$sheet->cells('A9:G9', function($cells) {
					$cells->setBackground('#eeeeee');
				});
				$sheet->cell('A7', function($cell) {
					$cell->setFontSize(16); 
				});
			});

		})->export('xls');
	} 

	public function report(Request $request) {

		$start_date = Carbon::parse($request->input('start_date'));
		
		$end_date = Carbon::parse($request->input('end_date'));
		$id = $request->input('employee_id');
		$campus_id = $request->input('campus_id');
		$employee = employee::where(['employee_id' => $id, 'campus_id' => $campus_id])->first();
		$schedule_id = $employee->schedule_id;
		$leaves = leave::where(['employee_id' => $id, 'status' => 1])->get();

		$leaves = $this->getLeaves($leaves);

		$results = Attendance::orderBy('date','ASC')->Where(['employee_id' => $id, 'campus_id' => $campus_id])->whereBetween(DB::raw("DATE_FORMAT(date,'%m/%d/%y')") , [$start_date->format('m/d/y'), $end_date->format('m/d/y')])->get()->toArray();
		
		$holidays = $this->getHolidays(); 

		$employee_name = $employee->first_name . ' ' . $employee->last_name;
		$employmentType = $employee->employment_type;
		
		$groupAttendance = $this->getAttendance($results); 

		$dataSet = [];
		$attendance = [];
		$totalMinutes = 0;
		$working = 0;
		$worked = 0;
		$absent = 0; 
		$late = 0;
		$totalOvertime = 0;

		for ($d = $start_date; $d->lte($end_date); $d->addDay(1) ) { 
			$date = $d->format('m/d/Y');
			$tardiness = 0;
			$dayOfWeek = Carbon::parse($date)->dayOfWeek;

            	//check if Holidays
			if ($holidays) {
				if ($key = array_search($date, $holidays)) {
					$dataSet[] = ['date' => $date, 'status' => 'holiday'];
					continue;
				}
			}
            	//Increment Working Days
			if ($employmentType == 1) {
				$sched = Schedule::where('id', $schedule_id)->first();
				$noWork = $this->getScheduleDays($sched->days);
				$hasWork = false;

				if (!in_array($dayOfWeek, $noWork[0])) {
					$working++;
					$hasWork = true;
				}

	            	//Check Status,Absent Or No Work
				if(!in_array($date, $groupAttendance['worked'][0]) || count($groupAttendance['attendance'][0][$date]) < 2 ) {

					$status = "";
					if (!in_array($dayOfWeek, $noWork) && $hasWork) {
						$status = "absent";
						$absent++;
					}else  
					$status = '--';
					$dataSet[] = ['date' => $date, 'status' => $status];
					continue;

				}


				$status = "present";

				//Merge Attendance Arrays
				$attendanceDate = [];

				foreach ( $groupAttendance['attendance'][0][$date] as $day) {
					$attendanceDate[] = $day['date'];
				}

				$max = max(array_map('strtotime', $attendanceDate));
				$min = min(array_map('strtotime', $attendanceDate));	
				$in = Carbon::createFromTimestamp($min);
				$out = Carbon::createFromTimestamp($max);

				$inTime = $in->format('h:i A');
				$outTime = $out->format('h:i A');
				$totalHours = 0;

				$timeIn = $sched->start;
				$timeOut = $sched->end;
				$totalHours  = $this->getTotalHoursAndOverTime($in, $out, $timeOut);

				if ( Carbon::parse($in->format('h:i'))->gt(Carbon::parse($timeIn)) ) {
					$status = "late";
					$tardiness = Carbon::parse($in->format('h:i'))->diffInMinutes(Carbon::parse($timeIn));
					$late += $tardiness;
				}

				$dataSet[] = [
					'date' => Carbon::parse($date)->format('Y-m-d'),
					'in' => $inTime,
					'out' => $outTime, 
					'status' => $status,
					'total_hours' => $totalHours[0]->format('%H') . ' hrs' . ' : ' . $totalHours[0]->format('%I') . ' min',
					'late' => $tardiness > 0 ? $tardiness . ' min' : 0,
					'overtime' => $totalHours[1] > 0 ? $totalHours[1] . ' min' : 0

				];

				$totalMinutes += $this->convertToMinutes($totalHours[0]);
				$totalOvertime += $totalHours[1];
				$worked++;

			}else if ($employmentType == 0) {
			 
				$sched = ParttimeSchedule::where(['employee_id' => $id, 'campus_id' => $campus_id])
										->where('day', $dayOfWeek)
										->orderBy('start', 'ASC')
										->get()->toArray();	

				if ($this->partTimeWorking($dayOfWeek, $sched))
					$working++;

				if ($this->partTimeWorking($dayOfWeek, $sched) && in_array($date, $groupAttendance['worked'][0])) {

					$dates = [];			 	 
					$timeIn = scheduleExist($dayOfWeek, 'start', $sched);
					$timeOut = scheduleExist($dayOfWeek, 'end', $sched);
					$maxHours = (int)getTotalHours($dayOfWeek, 'start', $sched);

					$attendances = Attendance::whereBetween('date', [Carbon::parse($date . ' ' . $timeIn)->subHours(1),
						Carbon::parse($date . ' ' . $timeOut)->addHours(5)
					])
					->where(['employee_id' => $id, 'campus_id' => $campus_id])
					->get()->toArray();

					foreach ($attendances as $attendance) {
						$dates[] = $attendance['date'];
					}

					if (count($dates) >= 2) {

						$max = max(array_map('strtotime', $dates));
						$min = min(array_map('strtotime', $dates));

						$in = Carbon::createFromTimestamp($min);
						$out = Carbon::createFromTimestamp($max);

						$inTime = $in->format('h:i A');
						$outTime = $out->format('h:i A');

						$totalHours = 0;
						$count = 0;


						if ($timeIn && $timeOut) { 

							$totalHours  = $this->getTotalHoursAndOverTime($in, $out, $timeOut);
							if ($count == 1) 
								dd($totalHours);

							if ( Carbon::parse($in->format('h:i'))->gt(Carbon::parse(Carbon::parse($timeIn)->format('h:i'))) ) {
								$status = "late";
								$tardiness = Carbon::parse($in->format('h:i A'))->diffInMinutes(Carbon::parse($timeIn));
								$late += $tardiness;
							}else {
								$status = "present";
							}
						}


					}else {

						$status = 'Absent';
						$absent++;
						$dataSet[] = ['date' => $date, 'status' => $status];
						continue;
					}

				}else if (in_array($dayOfWeek, array_column($sched, 'day')) && !in_array($date, $groupAttendance['worked'][0]))  {

					$status = 'Absent';
					$absent++;
					$dataSet[] = ['date' => $date, 'status' => $status];
					continue;

				}else{
					$status = '--';
					$dataSet[] = ['date' => $date, 'status' => $status];
					continue;
				}

				
				$totalMinutesToday = 0;

				if (Carbon::parse($outTime)->lt(Carbon::parse($timeOut))){

					foreach ($sched as $key => $schedTime) {

						if ($this->isInLeave($schedTime, $date))
							continue;

						if (Carbon::parse($schedTime['start'])->gte(Carbon::parse($inTime)->subHours(1)) && Carbon::parse($schedTime['end'])->lte(Carbon::parse($outTime)) ) { 

							$totalMinutesToday += Carbon::parse($schedTime['start'])->diffInMinutes(Carbon::parse($schedTime['end']));
							if (Carbon::parse($inTime)->gt(Carbon::parse($schedTime['start']))) {
								$totalMinutesToday -= Carbon::parse($inTime)->diffInMinutes(Carbon::parse($schedTime['start']));

							}

						}else  if (Carbon::parse($schedTime['end'])->diffInHours(Carbon::parse($outTime)) <= 1) 
						{
							 $totalMinutesToday += Carbon::parse($schedTime['start'])->diffInMinutes(Carbon::parse($schedTime['end']));
							 $totalMinutesToday -= Carbon::parse($outTime)->diffInMinutes(Carbon::parse($schedTime['end']));
						}

						

						continue;
					}



					$timeDiff = Carbon::parse($outTime)->diffInMinutes(Carbon::parse($timeOut));
					$newTimeOut = Carbon::parse($timeOut)->subMinutes($timeDiff);

					$totalMinutes += $totalMinutesToday; 

				}else if (Carbon::parse($outTime)->gte(Carbon::parse($timeOut))){
					$totalMinutes += $maxHours * 60;
					$totalMinutesToday = $maxHours * 60;

					if (Carbon::parse($inTime)->diffInMinutes(Carbon::parse($timeIn)) >= 30) {
						$status = 'Absent';
						$absent++;
						$dataSet[] = ['date' => $date, 'status' => $status];
						continue;
					}

					if (Carbon::parse($inTime)->gt(Carbon::parse($timeIn))) {
						$totalMinutesToday -= Carbon::parse($inTime)->diffInMinutes(Carbon::parse($timeIn));
						
					}
				}

				$totalOvertime += $totalHours[1];
				$worked++;

				$dataSet[] = [
					'date' => Carbon::parse($date)->format('Y-m-d'),
					'in' => $inTime,
					'out' => $outTime, 
					'status' => $status,
					'total_hours' => floor($totalMinutesToday / 60) . ' hrs :' . $totalMinutesToday % 60 . ' mins'  ,
					'late' => $tardiness > 0 ? $tardiness . ' mins' : 0,
					'overtime' => $totalHours[1] > 0 ? $totalHours[1] . ' min' : 0

				];

			}
		}

		$hours = floor($totalMinutes / 60);
		$minutes = $totalMinutes % 60;
		$attendance['data'] = $dataSet;
		$attendance['total_hours'] = $hours . ($minutes != 0 ? ' : '. $minutes  : '') . ' hrs';
		$attendance['worked'] = $worked . ' Days';
		$attendance['name'] = ucwords($employee_name);
		$attendance['working'] = $working . ' Days';
		$attendance['absent'] = $absent . ' Days';
		$attendance['employmentType'] = $employmentType;
		$attendance['late'] = $late;
		$attendance['overtime'] = $totalOvertime . ' mins';

		return json_encode($attendance);

	}

	public function isInLeave($schedule, $date) {
	 
		$leaves = Leave::where(['employee_id' => $schedule['employee_id'], 'campus_id' => $schedule['campus_id']])
						->where('date', date('Y-m-d', strtotime($date)))
						->get();
		 
		foreach ($leaves as $leave) {
			
			if ($leave->duration == 'short') {

				if (Carbon::parse($schedule['start'])->gte(Carbon::parse($leave->start)) && Carbon::parse($schedule['end'])->lte(Carbon::parse($leave->end)) ) {
						return true;
					}
			}
		}

	}

	public function convertToMinutes($timeDifference, $string = false) {
		$minutes = $timeDifference->format('%i');
		$hours = $timeDifference->format("%h");
		return (int) $minutes + ((int) $hours * 60);
	}

	public function getScheduleDays($schedDays) {
		$noWork = [];
		if ($schedDays == 0) 
			$noWork[] = [6,0];
		else if ($schedDays == 1) 
			$noWork[] = [0];
		else 
			$noWork[] = [];
		

		return $noWork;
	}

	public function partTimeWorking($dayOfWeek, $sched) {
		return in_array($dayOfWeek, array_column($sched, 'day'));
	}

	public function getTotalHoursAndOverTime($in, $out, $timeOut) {

		$out = Carbon::parse($out->format('h:i a'));
		$in = Carbon::parse($in->format('h:i a'));

		$timeOut = Carbon::parse($timeOut);


		if ($out->gt($timeOut)) {
			$overtime = Carbon::parse($out->format('h:i a'))->diffInMinutes(Carbon::parse($timeOut));
			$out = $out->subMinutes($overtime);
			if ($in->diffInHours($timeOut) > 5) {
				$out->subMinutes(60);
			}
			return [$in->diff($out), $overtime];
		}

		if ($in->diffInHours($out) > 5) {
			$out->subMinutes(60);
		}

		$totalHours = $out->diff($in); 
		return [$totalHours, 0];
	}
	
	public function file_upload(Request $request) {

		$request->validate([
			'campus_id' => 'required',
			'attendance' => 'required'
		]);
		$this->campus_id = $request->input('campus_id');

		if ($request->hasFile('attendance')) {			
			
			$extension = File::extension($request->file('attendance')->getClientOriginalName());

			if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

				$path = $request->file('attendance')->getRealPath();

				$data = Excel::load($path, function($reader) {

					$results =$reader->get()->toArray();

					foreach ($results as $result) {

						$row[] = $result;
					} 


					foreach($row as $row) {	

						if ($row['account_no'] && $row['date'] && $row['time']) {

							$data[] = array(
								'employee_id' => $row['account_no'], 
								'date' => Carbon::parse($row['date']->format('Y-m-d') . ' ' . $row['time']),
								'campus_id' => $this->campus_id
							);
						}

					}

					$insert = Attendance::insert($data);
					

				});

				return 1;

			}else {
				return 0;
			}
		} 
	}
}
