<?php

namespace App\Http\Controllers;

use App\Department;
use App\employee;
use App\Campus;
use App\Users;
use App\Schedule; 
use App\address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
use File;
use App\Roles;
use App\Leave;
class EmployeeController extends Controller
{
    
	public function index() {
     
		return view('Employee.index');	

	}

	public function new() {

		$departments = Department::select('id','name')->get();
        $campuses = Campus::select('id','name')->get();
        $roles = Roles::select('id','name')->orderBy('name')->get();
        $schedules = $this->getSchedules(Schedule::all());
       
		return view('Employee.new', compact('departments','campuses','roles','schedules'));

	}

    public function validateEmail(Request $request) {
        if (employee::where('email_address', $request->input('email_address'))->exists())
            return \Response::json('exists', 404);

        return \Response::json('not exists', 200);

    }

    public function validateID(Request $request) {
        if (employee::where('employee_id', $request->input('employee_id'))->exists())
            return \Response::json('exists', 404);

        return \Response::json('not exists', 200);

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
        dd($request->all());
        $employee->update_personal_details($request->all());
        return redirect()->back()->with('success-personal','Employee has been updated successfully');

    }

    public function updateEmploymentdetails(Request $request, employee $employee) {
       
        if ($request->input('current_campus') != $request->input('campus_id')) {
            
            $user = Users::where('campus_id', $request->input('current_campus'))
                    ->where('employee_id', $request->input('current_employee_id')) 
                    ->first();
                 
            $user->campus_id = $request->input('campus_id');
            $user->save();    
        }


        if ($employee->update_employment_details($request->all()))
            return redirect()->back()->with('update','employment');

        
        return redirect()->back()->with('update','employment')
                                ->with('error', 'Cannot update employee id');
    }

    public function edit(Request $request) {
        $id = $request->input('id');

        if ($id) {
            $employee = employee::where('id',$id)->first();
        
            if ($employee) {
                $scheduleID = 0;
                $this->authorize('edit',$employee);
                $role = Roles::where('id',$employee->role_id)->first();
                $roles = Roles::select('id','name')->get();
                $departments = Department::select('id','name')->get();
                $campuses = Campus::select('id','name')->get();
                $age = Carbon::parse($employee->birthday)->diffInYears(Carbon::now());
                $partimeScheds = Schedule::where(['employee_id' => $employee->employee_id, 'campus_id' => $employee->campus_id])
                            ->orderBy('day', 'ASC')
                            ->orderBy('start', 'ASC')
                            ->get()->toArray();
           
                $employee->work = json_decode($employee->work);
                $employee->training = json_decode($employee->training);
                $employee->civil_service = json_decode($employee->civil_service);
                $employee->involvement = json_decode($employee->involvement);
                $employee->voluntary = json_decode($employee->voluntary);
                $employee->educational_background = json_decode($employee->educational_background);
                $elementary = isset($employee->educational_background->elementary) ? $employee->educational_background->elementary : null;
                $secondary = isset($employee->educational_background->secondary) ? $employee->educational_background->secondary : null;
                $vocational = isset($employee->educational_background->vocational) ? $employee->educational_background->vocational : null;
                $college = isset($employee->educational_background->college) ? $employee->educational_background->college : null;
                $graduate = isset($employee->educational_background->graduate) ? $employee->educational_background->graduate : null;
                // dd($elementary);
                if ($partimeScheds)
                    $partimeScheds = $this->formatSchedules($partimeScheds);
                 
               // dd(isset($graduate->degree) ? $graduate->degree : '');
                return view('Employee.edit', compact(
                    'employee',
                    'departments',
                    'campuses',
                    'age',
                    'role',
                    'roles', 
                    'partimeScheds',
                    'elementary',
                    'secondary',
                    'vocational',
                    'college',
                    'graduate'
                ));
            }

        }
            
    }

    public function formatSchedules($sched) {
        $data = [];

        foreach ($sched as $s) {

            $data[$s['day']][] = $s;
        }

        return $data;
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

    public function storeEducationalBackground(Request $request) {
     //  dd($request->all());
        $elementary = array(
            'school' => $request->input('elementary-school'),
            'degree' => $request->input('elementary-degree'),
            'year' => $request->input('elementary-year'),
            'highestDegree' => $request->input('elementary-highestDegree'),
            'inclusiveDates' => $request->input('elementary-inclusiveDates'),
            'scholarship' => $request->input('elementary-scholarship'),
        ); 
        $secondary = array(
            'school' => $request->input('secondary-school'),
            'degree' => $request->input('secondary-degree'),
            'year' => $request->input('secondary-year'),
            'highestDegree' => $request->input('secondary-highestDegree'),
            'inclusiveDates' => $request->input('secondary-inclusiveDates'),
            'scholarship' => $request->input('secondary-scholarship'),
        ); 
        $vocational = array(
            'school' => $request->input('vocational-school'),
            'degree' => $request->input('vocational-degree'),
            'year' => $request->input('vocational-year') ,
            'highestDegree' => $request->input('vocational-highestDegree'),
            'inclusiveDates' => $request->input('vocational-inclusiveDates'),
            'scholarship' => $request->input('vocational-scholarship'),
        );
        $college = array(
            'school' => $request->input('college-school') ,
            'degree' => $request->input('college-degree'),
            'year' => $request->input('college-year'),
            'highestDegree' => $request->input('college-highestDegree'),
            'inclusiveDates' => $request->input('college-inclusiveDates'),
            'scholarship' => $request->input('college-scholarship'),
        );
        $graduate = array(
            'school' => $request->input('graduate-school'),
            'degree' => $request->input('graduate-degree') ,
            'year' => $request->input('graduate-year') ,
            'highestDegree' => $request->input('graduate-highestDegree'),
            'inclusiveDates' => $request->input('graduate-inclusiveDates'),
            'scholarship' => $request->input('graduate-scholarship') ,
        );
        $data = json_encode(array(
            'elementary' => $elementary,
            'secondary' => $secondary,
            'vocational' => $vocational,
            'college' => $college,
            'graduate' => $graduate
        )); 
        //dd($data);
        // dd($request->all());
        $employee = employee::find($request->input('id'));
       // dd($employee);
        $employee->educational_background = $data;
        $employee->save();
        return redirect()->back()->with('success','Updated successfully.');
    }

    public function profile(Request $request) {
        
        $id = $request->input('id');

        if ($id) {

            $profile = employee::select('employees.*','roles.name as role_name','departments.name as department_name','campuses.name as campus_name')
                            ->leftJoin('roles','roles.id','=', 'employees.role_id')
                            ->leftJoin('departments','departments.id','=','employees.department_id')
                            ->leftJoin('campuses','campuses.id','=','employees.campus_id')
                            ->where('employee_id', $id)->first();
          
            if ($profile) {
                
                $this->authorize('show', $profile);
                $scheduleID = 0;
                $age = (new Carbon($profile->birthday))->diffInYears(Carbon::now());
                $schedules = Schedule::where(['employee_id' => $profile->employee_id, 'campus_id' => $profile->campus_id])->orderBy('day','ASC')
                                ->orderBy('start', 'ASC')
                                ->get();
                if ($schedules)
                    $schedules = $this->formatSchedules($schedules);
              
                $address = address::where('employee_id',$profile->id)->first();
                $profile->educational_background = json_decode($profile->educational_background);
                $elementary = isset($profile->educational_background->elementary) ? $profile->educational_background->elementary : null;
                $secondary = isset($profile->educational_background->secondary) ? $profile->educational_background->secondary : null;
                $vocational = isset($profile->educational_background->vocational) ? $profile->educational_background->vocational : null;
                $college = isset($profile->educational_background->college) ? $profile->educational_background->college : null;
                $graduate = isset($profile->educational_background->graduate) ? $profile->educational_background->graduate : null;
                $profile->involvement = json_decode($profile->involvement);
                $profile->voluntary = json_decode($profile->voluntary);
                $profile->work = json_decode($profile->work);

                return view('Employee.profile',compact('profile','age','schedules','address', 'elementary', 'secondary', 'vocational', 'college', 'graduate'));
                    
                
            }

            abort(404);

        }
        
    }

    public function exportProfile(Request $request) {
        
        $id = $request->input('id');

        if ($id) {

            $profile = employee::select('employees.*','roles.name as role_name','departments.name as department_name','campuses.name as campus_name')
                            ->leftJoin('roles','roles.id','=', 'employees.role_id')
                            ->leftJoin('departments','departments.id','=','employees.department_id')
                            ->leftJoin('campuses','campuses.id','=','employees.campus_id')
                            ->where('employee_id', $id)->first();
          
            if ($profile) {
                
                $this->authorize('show', $profile);
                $scheduleID = 0;
                $age = (new Carbon($profile->birthday))->diffInYears(Carbon::now());
                $schedules = Schedule::where(['employee_id' => $profile->employee_id, 'campus_id' => $profile->campus_id])->orderBy('day','ASC')
                                ->orderBy('start', 'ASC')
                                ->get();
                if ($schedules)
                    $schedules = $this->formatSchedules($schedules);
              
                $address = address::where('employee_id',$profile->id)->first();
                $profile->educational_background = json_decode($profile->educational_background);
                $elementary = isset($profile->educational_background->elementary) ? $profile->educational_background->elementary : null;
                $secondary = isset($profile->educational_background->secondary) ? $profile->educational_background->secondary : null;
                $vocational = isset($profile->educational_background->vocational) ? $profile->educational_background->vocational : null;
                $college = isset($profile->educational_background->college) ? $profile->educational_background->college : null;
                $graduate = isset($profile->educational_background->graduate) ? $profile->educational_background->graduate : null;
                $profile->involvement = json_decode($profile->involvement);
                $profile->voluntary = json_decode($profile->voluntary);
                $profile->work = json_decode($profile->work);

                return view('Employee.export',compact('profile','age','schedules','address', 'elementary', 'secondary', 'vocational', 'college', 'graduate'));
                    
                
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
                Schedule::where($data)->delete();
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
                $resetLeaves = $employee->designation2 === "Faculty" ? '
                        <li>
                            <form method="get" action="' .url('reset/leaves'). '">
                                <input type="hidden" name="id" value="'.$employee->employee_id.'">
                                <button type="submit" class="btn-link"> <i class="fa fa-refresh"></i> Reset Leave </button>
                            </form>
                        </li>
                ' : "";
                $nestedData = [
                    $employee->employee_id,
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
                                    <form method="get" action="' .url('export/profile'). '"> 
                                        <input type="hidden" name="id" value="'.$employee->employee_id.'">
                                        <button type="submit" class="btn-link"> <i class="fa fa-file"></i> Export Profile </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="get" action="' .url('employee/profile'). '"> 
                                        <input type="hidden" name="id" value="'.$employee->employee_id.'">
                                        <button type="submit" class="btn-link"> <i class="fa fa-user"></i> Profile </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="get" action="' .url('employee/edit'). '">
                                        <input type="hidden" name="id" value="'.$employee->id.'">
                                        <button type="submit" class="btn-link"> <i class="fa fa-edit"></i> Edit </button>
                                    </form>
                                </li>
                                ' . $resetLeaves .  ' 
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

    public function resetLeaves(Request $request) {
        $id = $request->input('id'); 
        Leave::where('employee_id', $id)->update(['reset' => 1]);
        return redirect()->back()->with('success','Leave credits reset successfully.');
    }

    public function filterEmployee($campus_id, $employementType, $search,$start,$limit, $col, $dir) {
        
        if ($campus_id && $employementType) {
            return  employee::offset($start)
                        ->limit($limit)
                        ->where(['campus_id' => $campus_id, 'employment_type' => $employementType]) 
                        ->orderBy($col,$dir)
                        ->get();
        }

        if ($campus_id) {
            return  employee::offset($start)
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

            return employee::offset($start)
                        ->limit($limit)
                        ->orderBy($col,$dir)
                        ->get();
        }
        if ($search !== "") {
            return employee::offset($start)
                    ->limit($limit)
                    ->where(DB::raw('CONCAT(first_name, " ",last_name)'), 'LIKE', '%' . $search . '%') 
                    ->orderBy($col,$dir)
                    ->get();
        }
        
    }

    public function getEmployeesByCampus(Request $request) {
        return json_encode(employee::where('campus_id', $request->campus_id)->get());
    }

    public function storeWorkExp(Request $request) {
        //dd($request->all());
        $id = $request->input('id');
        $work = $request->input('exp_data');
        $employee = employee::find($id);
        $employee->work = $work;
        $employee->save();
        return redirect()->back()->with('success','Updated successfully.');
    }

    public function storeTrainingProgram(Request $request) {
        //dd($request->all());
        $id = $request->input('id');
        $training = $request->input('training_data');
        $employee = employee::find($id);
        $employee->training = $training;
        $employee->save();
        return redirect()->back()->with('success','Updated successfully.');
    }

    public function storeEmployeeInfo(Request $request) {
        $id = $request->input('id');
        $hobbies = $request->input('hobbies');
        $awards = $request->input('awards');
        $employee = employee::find($id);
        $employee->hobbies = $hobbies;
        $employee->awards = $awards;
        $employee->save();
        return redirect()->back()->with('success','Updated successfully.');
    }

    public function storeCareer(Request $request) {
        $id = $request->input('id');
        $data = $request->input('civil_service_data');
        $employee = employee::find($id);
        $employee->civil_service = $data;
        $employee->save();
        return redirect()->back()->with('success','Updated successfully.');
    }

    public function storeInvolvement(Request $request) { 
        // dd($request->all());
        $id = $request->input('id');
        $data = $request->input('involvement_data');
        $employee = employee::find($id);
        $employee->involvement = $data;
        $employee->save();
        return redirect()->back()->with('success','Updated successfully.');
    }

    public function storeVoluntary(Request $request) { 
        //dd($request->all());
        $id = $request->input('id');
        $data = $request->input('voluntary_data');
        $employee = employee::find($id);
        $employee->voluntary = $data;
        $employee->save();
        return redirect()->back()->with('success','Updated successfully.');
    }
}
