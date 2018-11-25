<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{

	public function index() {
		return view('Schedule.index');
	}

	public function insert(Request $request) {
		return Schedule::create([
			'name' => $request->input('name'),
			'start' => Carbon::parse($request->input('start'))->format('H:i:s'),
			'end' => Carbon::parse($request->input('end'))->format('H:i:s'),
			'days' => $request->input('days')
			])->id;

	}

	public function destroy(Request $request) {
		return Schedule::where('id', $request->input('id'))->delete();
	}

	public function update(Request $request) {
		
		Schedule::where('id', $request->input('id'))
				->update([
					'name' => $request->input('name'),
					'start' => Carbon::parse($request->input('start'))->format('H:i:s'),
					'end' => Carbon::parse($request->input('end'))->format('H:i:s'),
					'days' => $request->input('days')
				]);

		return redirect()->back();
	}

	public function data(Request $request) {
		$totalData = Schedule::count();

		$limit = intval($request->input('length'));
		$start = intval($request->input('start'));
		$order = intval($request->input('order.0.column'));
		$dir = $request->input('order.0.dir');
		$search = $request->input('search');
		$col = $request->input("columns.$order.name");

		$schedules = Schedule::offset($start)
		->limit($limit)
		->orderBy($col,$dir)
		->get();
		$days = config('config.scheduleDays');
		$data = [];

		if ($schedules) {
			$counter = 0;
			foreach ($schedules as $schedule) {
				$counter++;
				$nestedData = [
				ucwords($schedule->name),
				date('h:i A',strtotime($schedule->start)),
				date('h:i A',strtotime($schedule->end)),
				$days[$schedule->days],
				'<div class="dropdown">
				<a class="icon_action btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">
					Action
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li>
						<form > 
							 
							<button type="submit" class="btn-link edit" data-id="'.$schedule->id.'"> <i class="fa fa-edit" ></i> Edit </button>
						</form>
					</li>
					<li>
						<form method="post" action="' .url('schedule/destroy'). '" class="delete-form" data-name="Schedule">
							<input type="hidden" name="_token" value="'.csrf_token() . '">
							<input type="hidden" name="id" value="'.$schedule->id.'">
							<input name="_method" type="hidden" value="delete">

							<button type="submit" class="btn-link"> <i class="fa fa-trash"></i> delete </button>
						</form>
					</li>
				</ul>
			</div>
			'
			];
			$data[] = $nestedData;
			}
		}

		$json_data = array(
			'draw' => $request->input('draw'),
			'recordsTotal' => intval($totalData),
			'recordsFiltered' => $totalData,
			'data' => $data,
			'paging' => 'false'
			);

		echo json_encode($json_data);
	}
}
