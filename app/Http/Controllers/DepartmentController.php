<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use App\Campus;
use App\employee;
use App\departmentHeads;

class DepartmentController extends Controller
{
	public function index() {

 		return view('Department.index');
	}

	public function new() {
		$campuses = Campus::all();

		return view('Department.new',compact('campuses'));
	}

	public function edit(Request $request) {

		$department = Department::find($request->input('id'));
		 
	 	
		return view('Department.edit',compact('department'));
	}

	public function update(Request $request) {

		$id = $request->input('id');
		$update = Department::where('id', $id)->update([
				'name' => $request->input('department_name'),
		 		'description' => $request->input('department_details')
			]);

		if ($update)
			return redirect()->back()->with('success','Department has been updated successfully');

	}

	public function save(Request $request) {
	  
	    $request->validate([
	    			'campus_id' => 'required|max:50',
	 			'department_name' => 'required|max:50',  
	 			'description' => 'required|max:50'
	 		]);

	 	$department = new Department;
	 	$department->campus_id = $request->input('campus_id');
		$department->name = $request->input('department_name');
		$department->description = $request->input('description'); 

		if ($department->save()) {
			return redirect()->back()->with('success','Department added successfully...');
		}

	}

	public function destroyRow(Department $department, Request $request) {

		$id = $request->input('id');

		if ($department->deleteRow($id)) {
			return redirect('department');
		}
	}

	public function data(Request $request) {

		$totalData = Department::count();
	     $limit = intval($request->input('length'));
	     $start = intval($request->input('start'));
	     $order = intval($request->input('order.0.column'));
	     $dir = $request->input('order.0.dir');
	     $search = $request->input('search.value');
	     $col = $request->input("columns.$order.name");

	     $campus_id = $request->input("columns.3.search.value");
	    	
	     if ($campus_id) {
	     	$departments = Department::offset($start)
	     					->limit($limit)
	     					->orderBy($col,$dir)
	     					->where('campus_id', $campus_id)
	     					->get();
	     }else if ($search) {
	     	$departments = Department::offset($start)
	     					->limit($limit)
	     					->orderBy($col,$dir)
	     					->where('name', 'like', '%' . $search . '%')
	     					->get();
	     }else {
	     	$departments = Department::offset($start)
	     					->limit($limit)
	     					->orderBy($col,$dir)
	     					->get();
	     }


	     

	     $data = [];

	     if ($departments) {
	     	$counter = 0;
	     	foreach ($departments as $department) {
	     		$campus = Campus::select('name')->where('id', $department->campus_id)->first()->name;

	     		$counter++;
	     		$nestedData = [
	     			$campus,
	     			ucwords($department->name),
	     			ucfirst($department->description), 
	     			'<div class="dropdown">
						<a class="icon_action btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">
						Action
							<span class="caret"></span>
						</a>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li>
							<form> 
								<button data-id="'. $department->id .'" data-campus="'. $department->campus_id .'" type="button" class="btn-link heads" data-toggle="modal" data-target="#modal-heads"> <i class="fa fa-users"></i>  Heads</button>
							</form>
							</li>
							<li>
							<form method="get" action="' .url('department/edit'). '"> 
								<input type="hidden" name="id" value="'.$department->id.'">
								<button type="submit" class="btn-link"> <i class="fa fa-edit"></i> Edit </button>
							</form>
							</li>
							<li>
								<form method="post" action="' .url('department/destroy'). '" class="delete-form" data-name="Department">
									<input type="hidden" name="_token" value="'.csrf_token() . '">
									<input type="hidden" name="id" value="'.$department->id.'">
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

	     	$json_data = array(
	     		'draw' => $request->input('draw'),
	     		'recordsTotal' => intval($totalData),
	                'recordsFiltered' => $totalData,
	                'data' => $data,
	                'paging' => 'false',
	                'test' => $campus_id
	     		);

	     	echo json_encode($json_data);
	     }
	}

}
