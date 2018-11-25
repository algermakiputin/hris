<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave_type;
use App\Roles;
use App\Campus;
use App\Department;

class LeaveTypeController extends Controller
{
    public function type() {

		$leave_types = Leave_type::all();
        $roles = new Roles(); 
        $campuses = new Campus();
        $departments = new Department;   

		return view('LeaveType.type',compact('leave_types','roles','campuses','departments'));
	}

    public function data(Request $request) {

        $totalData = Leave_type::count();
        $limit = intval($request->input('length'));
        $start = intval($request->input('start'));
        $order = intval($request->input('order.0.column'));
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $col = $request->input("columns.$order.name");
        $campus_id = $request->input("columns.1.search.value");

        if ($campus_id) {
            $LeaveTypes = Leave_type::offset($start)
                            ->limit($limit)
                            ->orderBy($col,$dir)
                            ->where('campus_id', $campus_id)
                            ->get();
        }else if ($search){
            $LeaveTypes = Leave_type::offset($start)
                            ->limit($limit)
                            ->orderBy($col,$dir)
                            ->where('name','like', '%' . $search . '%')
                            ->get();
        }else {
            $LeaveTypes = Leave_type::offset($start)
                            ->limit($limit)
                            ->orderBy($col,$dir)
                            ->get();
        }
         
         $data = [];

        if ($LeaveTypes) {
            $counter = 0;
            foreach ($LeaveTypes as $leaveType) {
                $counter++;
                $nestedData = [
                    $leaveType->name, 
                    (new Campus)->getName($leaveType->campus_id),
                    (new Department)->getName($leaveType->department_id), 
                    $leaveType->description,
                    $leaveType->allowance,
                    '<div class="dropdown">
                        <a class="icon_action btn-success dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">
                        Action
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                            <form method="get" action="'. url('leave-type/edit') .'">
                                <input type="hidden" name="id" value="'.$leaveType->id.'">
                                <button type="submit" class="btn-link"> <i class="fa fa-edit"></i> Edit </button>
                            </form>
                        </li>
                        <li>
                            <form method="post" action="'. url('leave-type/delete') .'" 
                            class="delete-form" data-name="Leave Type">
                                <input type="hidden" name="_token" value="'. csrf_token() .'">
                                <input type="hidden" name="id" value="'.$leaveType->id.'">
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
                'paging' => 'false',
                'test' => $campus_id
        );

        echo json_encode($json_data);
    }

	public function add_type() {

        $roles = Roles::select('name','id')->get(); 
        $campuses = Campus::all();   
		return view('LeaveType.add_type',compact('roles','campuses'));
	}

	public function insert(Request $request){

        $validate = $request->validate([
                'name' => 'required|max:50',
                'description' => 'required|max:80',
                'campus' => 'required|max:10',
                'department' => 'required|max:10'
            ]);
		$leave_type = new Leave_type;

		$leave_type->name = $request->input('name');
		$leave_type->description = $request->input('description');
        $leave_type->allowance = $request->input('allowance'); 
        $leave_type->department_id = $request->input('department');
        $leave_type->campus_id = $request->input('campus');
		if ($leave_type->save()) {

			return redirect()->back()->with('success','Leave type has been added successfully');
		}

	}

    public function destroyRow(Request $request) {
        
        try {

            $id = $request->input('id');
            Leave_type::find($id)->delete();
            return redirect()->back();

        } catch (\Illuminate\Database\QueryException $e) {
            

        }
    }

    public function edit(Request $request) {

        $id = $request->input('id');
        $type = Leave_type::find($id);
        $campus_id = $type->campus_id;
        $department_id = $type->department_id; 
        $campuses = Campus::all();
        $departments = Department::where('campus_id', $campus_id)->get();
         
        
       
        $data = array('type','campuses','departments','campus_id','department_id');

        return view('LeaveType.edit',compact($data));
    }

    public function update(Request $request) {

        $id = $request->input('id');

        $leave_type = Leave_type::find($id);

        $leave_type->name = $request->input('name');
        $leave_type->allowance = $request->input('allowance');
        $leave_type->description = $request->input('description'); 
        $leave_type->department_id = $request->input('department');
        $leave_type->campus_id = $request->input('campus');


        if ($leave_type->save()) {
            return redirect()->back()->with('success','Leave type updated successfully');
        }

         
    }

     
}
