<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\employee;
use App\Roles;
use App\Department;

class RolesController extends Controller
{
	public function index() {

		return view('Roles.index');
	}

	public function data(Request $request) {

		$totalData = Roles::count();

	     $limit = intval($request->input('length'));
	     $start = intval($request->input('start'));
	     $order = intval($request->input('order.0.column'));
	     $dir = $request->input('order.0.dir');
	     $search = $request->input('search');
	     $col = $request->input("columns.$order.name");
	    	$campus_id = $request->input("columns.0.search.value");

	   
    		$roles = Roles::offset($start)
					->limit($limit) 
					->get();

	     $data = [];

	     if ($roles) {
	     	$counter = 0;
	     	foreach ($roles as $role) {
	     		$counter++;
	     		$nestedData = [ 
	     			ucwords($role->name),
	     			ucfirst($role->description), 
	     			employee::where('role_id', $role->id)->count(),
	     			'<div class="dropdown">
						<a class="icon_action btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">
						Action
							<span class="caret"></span>
						</a>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li>
							<form method="get" action="' .url('roles/edit'). '"> 
								<input type="hidden" name="id" value="'.$role->id.'">
								<button type="submit" class="btn-link"> <i class="fa fa-edit"></i> Edit </button>
							</form>
							</li>
							<li>
								<form>
									<button data-id="'.$role->id.'" type="button" class="btn-link delete"> <i class="fa fa-trash"></i> delete </button>
								</form>
							</li>
						 	</ul>
						</div>
	     			 '
	     		];
	     		$data[] = $nestedData;
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

	public function destroy(Request $request) {

		return Roles::where('id',$request->input('id'))->delete();

	}

	public function edit(Request $request) {

		$role = Roles::find($request->input('id'));
	 	 
		return view('Roles.edit', compact('departments','role','campuses','campus_id','currentCampusDepartments'));
	}

	public function update(Request $request) {

		Roles::where('id',$request->input('id'))->update([
				'name' => $request->input('name'),
				'description' => $request->input('description')
			]);

		return redirect()->back()->with('success','Role updated successfully');
	}

	public function new() { 
		return view('Roles.new');
	}

	public function insert(Request $request) { 
		$request->validate([
				'name' => 'required',
				'description' => 'required'
			]);

		Roles::create([
				'name' => $request->input('name'),
				'description' => $request->input('description') 
			]);

		return redirect()->back()->with('success','New role added successfully');
	}

	public function getCampusDepartments(Request $request) {
		$campus_id = $request->input('campus_id');
		return json_encode(Department::where('campus_id', $campus_id)->get());

	}
}
