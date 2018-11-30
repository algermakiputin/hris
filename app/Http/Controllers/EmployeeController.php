<?php

namespace App\Http\Controllers;

use App\Department;
use App\employee;
use App\Campus;
use App\Users;
use App\Schedule;
use App\ParttimeSchedule;
use App\address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
use File;
use App\Roles;

class EmployeeController extends Controller
{
    
	public function index() {
     
		return view('Employee.index');	

	}

	public function new() {

		$departments = Department::select('id','name')->get();
        $campuses = Campus::select('id','name')->get();
        $roles = Roles::select('id','name')->get();
        $schedules = $this->getSchedules(Schedule::all());
       
		return view('Employee.new', compact('departments','campuses','roles','schedules'));

	}

    public function getSchedules($schedules) {
        $sched = [];
        foreach ($schedules as $schedule) {
            $sched[] = [
                'id' => $schedule->id,
                'name' => $schedule->name,
                'start' => Carbon::parse($schedule->start)->format('h:i A'),
                'end' => Carbon::parse($schedule->end)->format('h:i A'),
            ];
        }

        return $sched;
    }

    public function uploadAvatar(Request $request) {
        $request->validate([
                'avatar' => 'required|mimes:jpg,jpeg,bmp,png'
            ]);

        if ($request->hasFile('avatar')) {
            if ($request->input('old_img')) {
                Storage::delete('public/avatar/' . $request->input('old_img'));
            }
            
            $path = $request->file('avatar')->store('public/avatar');
            $fileName = basename($path);

            employee::where('employee_id', $request->input('_id'))->update(['avatar' => $fileName]);
            Users::where('employee_id', $request->input('_id'))->update(['avatar' => $fileName]);
            return redirect()->back()->with('success-upload', 'Avatar uploaded successfully');
        }

        
    }

    public function activate_account() {
        return view('auth.activate_account');
    }

    public function activate(Request $request) {

        $employee = employee::where(['email_address' => $request->input('email'), 'activated' => 0])->first();
      
        if ($employee) {

            Users::create([
                    'name' => $employee->first_name . ' ' . $employee->last_name,
                    'email' => $employee->email_address,
                    'password' =>  Hash::make($request->input('password')),
                    'role' => 'staff',
                    'employee_id' => $employee->employee_id
                ]);
        }

    }

    public function update(Request $request, employee $employee) {
        
        $employee->update_personal_details($request->all());
        return redirect()->back()->with('success-personal','Employee has been updated successfully');

    }

    public function updateEmploymentdetails(Request $request, employee $employee) {

        $employee->update_employment_details($request->all());
        return redirect()->back()->with('update','employment');
    
    }

    public function edit(Request $request) {
        $id = $request->input('id');

        if ($id) {
            $employee = employee::where('employee_id',$id)->first();

            if ($employee) {
                $scheduleID = 0;
                $this->authorize('edit',$employee);
                $role = Roles::where('id',$employee->role_id)->first();
                $roles = Roles::select('id','name')->get();
                $departments = Department::select('id','name')->get();
                $campuses = Campus::select('id','name')->get();
                $age = Carbon::parse($employee->birthday)->diffInYears(Carbon::now());
                $partimeScheds = ParttimeSchedule::where(['employee_id' => $employee->employee_id, 'campus_id' => $employee->campus_id])->get()->toArray();
                $schedules = Schedule::all();
             
                if ($employee->employment_type == 1) 
                    $scheduleID = $employee->schedule_id;
             
                return view('Employee.edit', compact('employee','departments','campuses','age','role','roles', 'partimeScheds','schedules','scheduleID'));
            }

        }
        
         
            
    }

    public function resumeUpdate(Request $request) {

	    $request->validate([
	        'resume' => 'required|mimes:docx,pdf'
        ]);

	    $id = $request->input('id');

        if ($request->input('old_file'))
            Storage::delete('public/resume/' . $request->input('old_file'));

        $file = Input::file('resume');

        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extention = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        do{
            $fileName .= rand(0, 100);
        }while(Storage::exists(url('public/resume/') . $fileName . '.' . $extention));

        $file->storeAs('public/resume/', $fileName . '.' . $extention);
        employee::where('id', $id)->update(['resume' => $fileName . '.' . $extention]);
        return redirect()->back()->with('update','resume');
    
    }

	public function insert(Request $request) {
       
        $request->validate([
            'first_name' => 'required|max:50',
            'family_name' => 'required|max:50',
            'middle_initial' => 'required|max:50',
            'age' => 'required|max:50',
            'street_address' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'zipcode' => 'required|max:50',
            'gender' => 'required|max:50',
            'birthday' => 'required|max:50',
            'email_address' => 'required|max:50',
            'mobile' => 'required|max:50',
            'telephone' => 'max:50',
            'marital_status' => 'required|max:50',
            'designation' => 'required|max:50',
            'department' => 'required|max:50',
            'employment_type' => 'required|max:50',
            'salary' => 'required|max:50',
            'date_joining' => 'required|max:50',
            'resume' => 'max:2500',
            'status' => 'required'
        ]);

        $employee = new employee;
        $avatar = null;

        if (Input::hasFile('resume')) {

            $file = Input::file('resume');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extention = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

            do {

                $fileName .= rand(0, 100);

            }while(Storage::exists(url('public/resume/') . $fileName . '.' . $extention));

            $file->storeAs('public/resume/', $fileName . '.' . $extention);

            $avatar = $fileName . '.' . $extention;
        }
        

        DB::transaction(function() use ($request, $avatar, $employee) {
            $store = $employee->store($request->all(), $avatar);
        
            address::create([
                    'employee_id' => $store,
                    'address' => $request->input('street_address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zipcode' => $request->input('zipcode')
                ]);

            Users::create([
                    'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                    'email' => $request->input('email_address'),
                    'password' =>  '',
                    'role' => 0,
                    'employee_id' => $request->input('employee_id'),
                    'campus_id' => $request->input('campus_id'),
                    'active' => 0,
                    'campus_id' => $request->input('campus')
                ]);

            return redirect()->back()->with('messsage','Employee added successfully...')->with('success','Employee has been added successfully');
        });
        
        return redirect()->back()->with('error','Opps! something went wrong, please try again.');
           
        
	}

    public function profile(Request $request) {
        
        $id = $request->input('id');

        if ($id) {

            $profile = employee::select('employees.id','tenure','education','employee_id','employees.campus_id as campus_id','avatar','first_name','last_name','middle_name','gender','schedule_id','birthday','email_address','mobile','telephone','marital_status','role_id','employment_type','salary','date_joining','resume','status', 'roles.name as role_name','departments.name as department_name','campuses.name as campus_name')
                            ->leftJoin('roles','roles.id','=', 'employees.role_id')
                            ->leftJoin('departments','departments.id','=','employees.department_id')
                            ->leftJoin('campuses','campuses.id','=','employees.campus_id')
                            ->where('employee_id', $id)->first();
          
            if ($profile) {
                
                $this->authorize('show', $profile);
                $scheduleID = 0;
                $age = (new Carbon($profile->birthday))->diffInYears(Carbon::now());
                $schedules = ParttimeSchedule::where(['employee_id' => $profile->employee_id, 'campus_id' => $profile->campus_id])->get();
                $address = address::where('employee_id',$profile->id)->first();
                if ($profile->employment_type == 1) {
                    $sched = Schedule::find($profile->schedule_id);
                    $scheduleID = $sched->name . ': ' . toTime($sched->start) . ' - ' . toTime($sched->end);
                
                }

               
                return view('Employee.profile',compact('profile','campus','age','schedules','address','scheduleID'));
                    
                
            }

            abort(404);

        }
        
    }

    public function destroy(Request $request) {

        $id = $request->input('id');

        return DB::transaction(function() use ($id) {
            $employee = employee::find($id);
            $data = ['employee_id' => $employee->employee_id, 'campus_id' => $employee->campus_id];
            employee::where($data)->delete();
            Users::where($data)->delete();
            if ($employee->employment_type == 0) 
                ParttimeSchedule::where($data)->delete();
        });
       
        
        
    }

    public function getAge($birthday) {

        return $birthday->diffInYears(Carbon::now());

    }

    public function data(Request $request) {
        
        $totalData = employee::count();

        $limit = intval($request->input('length'));
        $start = intval($request->input('start'));
        $order = intval($request->input('order.0.column'));
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $col = $request->input("columns.$order.name");
        $employementType = $request->input('columns.7.search.value');
        $campus_id = $request->input('columns.1.search.value');

        $employees = $this->filterEmployee($campus_id,$employementType, $search,$start, $limit, $col,$dir);
        
        $data = [];

        if ($employees) {
            $counter = 0;
            
            foreach ($employees as $employee) {
                $nestedData = [
                    ucwords($employee->first_name . ' ' . $employee->last_name),
                    Campus::find($employee->campus_id)->name,
                    Roles::find($employee->role_id)->name,
                    Department::find($employee->department_id)->name,
                    '₱'. number_format((int)$employee->salary),
                    $employee->email_address,
                    $employee->status ? 'Active' : 'In Active',
                    '                  
                        <div class="dropdown">
                        <a class="icon_action btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">
                        Action
                            <span class="caret"></span>
                        </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li>
                                    <form method="get" action="' .url('employee/profile'). '"> 
                                        <input type="hidden" name="id" value="'.$employee->employee_id.'">
                                        <button type="submit" class="btn-link"> <i class="fa fa-user"></i> Profile </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="get" action="' .url('employee/edit'). '">
                                        <input type="hidden" name="id" value="'.$employee->employee_id.'">
                                        <button type="submit" class="btn-link"> <i class="fa fa-edit"></i> Edit </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="post" action="' .url('employee/destroy'). '" class="delete-form" data-name ="Employee">
                                        <input type="hidden" name="_token" value="'.csrf_token() . '">
                                        <input type="hidden" name="id" value="'.$employee->id.'">
                                        <input type="hidden" name="_method" value="delete">
                                        <button type="submit" class="btn-link"> <i class="fa fa-trash"></i> Delete </button>
                                    </form>
                                </li>
                                
                            </ul>
                        </div>                    
                    '
                ];

                $data[] = $nestedData;
        }

        $json_data = array(
                'test' => $employementType,
                'draw' => $request->input('draw'),
                'recordsTotal' => intval($totalData),
                    'recordsFiltered' => $totalData,
                    'data' => $data,
                    'paging' => 'false'
                );

            return json_encode($json_data);
        }
    }

    public function filterEmployee($campus_id, $employementType, $search,$start,$limit, $col, $dir) {
        
        if ($campus_id && $employementType) {
            return  employee::select('id','first_name','last_name','salary','employee_id','role_id','department_id','email_address','status','campus_id')
                        ->offset($start)
                        ->limit($limit)
                        ->where(['campus_id' => $campus_id, 'employment_type' => $employementType]) 
                        ->orderBy($col,$dir)
                        ->get();
        }

        if ($campus_id) {
            return  employee::select('id','first_name','last_name','salary','employee_id','role_id','department_id','email_address','status','campus_id')
                        ->offset($start)
                        ->limit($limit)
                        ->where(['campus_id' => $campus_id]) 
                        ->orderBy($col,$dir)
                        ->get();
        }

        if ($employementType !== null) {
            return  employee::offset($start)
                        ->limit($limit)
                        ->where(['employment_type' => $employementType]) 
                        ->orderBy($col,$dir)
                        ->get();
            
        }
        if ($employementType == "" && $search == ""){

            return employee::select('id','first_name','last_name','salary','employee_id','role_id','department_id','email_address','status','campus_id')
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($col,$dir)
                        ->get();
        }
        if ($search !== "") {
            return employee::select('id','first_name','last_name','salary','employee_id','role_id','department_id','email_address','status','campus_id')
                    ->offset($start)
                    ->limit($limit)
                    ->where(DB::raw('CONCAT(first_name, " ",last_name)'), 'LIKE', '%' . $search . '%') 
                    ->orderBy($col,$dir)
                    ->get();
        }
     
        
        
    }
}
