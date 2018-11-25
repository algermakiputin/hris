<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\employee;
use App\Department;

class CampusController extends Controller
{
   public function index() {

      $campuses = Campus::all();

      return view('Campus.index',compact('campuses'));

  }

  public function getCampuses() {

      return json_encode(Campus::all());
  }

  public function getDepartments(Request $request) {

      $departments = Department::where('campus_id', $request->input('campus_id'))->get();
      return json_encode($departments);
  }

  public function data(Request $request) {

    $totalData = Campus::count();

    $limit = intval($request->input('length'));
    $start = intval($request->input('start'));
    $order = intval($request->input('order.0.column'));
    $dir = $request->input('order.0.dir');
    $search = $request->input('search.value');
    $col = $request->input("columns.$order.name");

    if ($search) {
        $campuses = Campus::offset($start)
                      ->limit($limit)
                      ->orderBy($col,$dir)
                      ->where('name', 'like', '%' . $search . '%')
                      ->get();
    }else {
        $campuses = Campus::offset($start)
                      ->limit($limit)
                      ->orderBy($col,$dir)
                      ->get();
    }

    $data = [];

    if ($campuses) {
        $counter = 0;
        foreach ($campuses as $campus) {
            $counter++;
            $nestedData = [
              ucwords($campus->name),
              ucfirst($campus->description), 
              Department::where('campus_id', $campus->id)->count(),
              employee::where('campus_id', $campus->id)->count(),
              '
              <div class="dropdown">
                  <a class="icon_action btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">
                      Action
                      <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li>
                          <form method="get" action="' .url('campus/edit'). '"> 
                              <input type="hidden" name="id" value="'.$campus->id.'">
                              <button type="submit" class="btn-link"> <i class="fa fa-edit"></i> Edit </button>
                          </form>
                      </li>
                      <li>
                          <form method="post" action="' .url('campus/delete'). '" class="delete-form" data-name="Campus">

                              <input type="hidden" name="_token" value="'.csrf_token() . '">
                              <input type="hidden" name="id" value="'.$campus->id.'"> 

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
            'paging' => 'false'
            );

        echo json_encode($json_data);
    }
}

public function new() {

  return view('Campus.new');
}

public function save(Request $request) {
  $campus = new Campus;

  $campus->name = $request->input('name');
  $campus->description = $request->input('description'); 

  if ($campus->save()) 
    return redirect()->back()->with('success','New campus has been added successfully');

}

public function edit(Request $request) {
  $id = $request->input('id');
  $campus = Campus::find($id);

  return view('Campus.edit',compact('campus'));

}

public function update(Request $request) {
  $id = $request->input('id');

  $update = Campus::where('id', $id)->update([
    'name' => $request->input('name'),
    'description' => $request->input('description'),
    'head' => $request->input('head')
    ]);

  if ($update)
     return redirect()->back()->with('success','Campus has been updated successfully');
}

public function destroy(Request $request, Campus $campus) {
  $id = $request->input('id');

  if ($campus->where('id',$id)->delete()) 
     return redirect('campus');


}
}
