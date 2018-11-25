<?php

namespace App\Http\Controllers;

use App\Users;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use Session;

use Auth;

class UsersController extends Controller
{
     

	public function index() {

		return view('Users.index');
	}

    public function adminProfile(Request $request) {
        $user = Users::where('id', $request->input('id'))->first();
        return view('Users.adminProfile',compact('user'));
    }

    public function adminEdit(Request $request) {

        $user = Users::where('id', $request->input('id'))->first();
        return view('Users.adminEdit',compact('user'));
    }

    public function adminUpdate(Request $request) {
    
        
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('public/avatar');
            $fileName = basename($path);

            Users::where('id', $request->input('id'))->update(['name' => $request->input('name'),'avatar' => $fileName]);
        
            return redirect()->back()->with('success','Profile updated successfully');
            
        }
        
         
        Users::where('id', $request->input('id'))->update(['name' => $request->input('name')]);
        
        return redirect()->back()->with('success','Profile updated successfully');

    }

    public function validateAccount(Request $request) {

        $email = $request->input('email');

        $user = Users::select('email','id')->where(['email' => $email,'active' => 0])->first();

        if ($user) 
            return view('auth.setPassword',compact('user'));

        return redirect()->back()->with('email','No record found in our database');
    }

    public function data(Request $request) {

        $totalData = Users::count();

         $limit = intval($request->input('length'));
         $start = intval($request->input('start'));
         $order = intval($request->input('order.0.column'));
         $dir = $request->input('order.0.dir');
         $search = $request->input('search.value');
         $col = $request->input("columns.$order.name");

         if ($search !== ""){
            $users = Users::offset($start)
                        ->limit($limit)
                        ->orderBy($col,$dir)
                        ->where('name', 'LIKE', '%' . $search . '%')
                        ->get();
         }else {
            $users = Users::offset($start)
                        ->limit($limit)
                        ->orderBy($col,$dir)
                        ->get();
         }

         $data = [];

         if ($users) {
            $counter = 0;
            foreach ($users as $user) {
                $counter++;
                $nestedData = [
                    ucwords($user->name),
                    $user->email,
                    config('config.access')[$user->role],
                    $user->active ? 'Active' : 'Inactive',
                    '
                    <div class="dropdown">
                    <a class="icon_action btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding:3px 7px;border-radius:5px; ">
                    Action
                        <span class="caret"></span>
                    </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                        <form action = "'. url('user/edit') .'" method="POST" class="user_edit">
                            <input type="hidden" name="_token" value="'.csrf_token() . '">
                          
                            <input type="hidden" name="id" value="'. $user->id .'">
                            <button type="submit" class="btn-link"> <i class="fa fa-edit"></i> Edit Role</button>
                        </form>
                        </li>
                        <li>
                        <form action ="'. url('user/edit').'" method="POST" class="user_delete delete-form">
                            <input type="hidden" name="_token" value="'.csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="'. $user->id .'">
                            <button type="submit" class="btn-link"> <i class="fa fa-trash"></i> delete</button>
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

		return view('Users.new');
	}

	public function insert(Request $request) {
		$user = new Users;

        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'), 
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
            
            );
		
        $user->store($data);
		
        if ($user)  
          return redirect()->back()->with('success', 'User registered successfully');
 
	}

    public function edit(Request $request) {

    		$id = $request->input('id');
        	$user = Users::find($id)->toArray();
        	return view('Users.edit',compact('user'));

    }

    public function updatePassword(Request $request) {  

        $request->validate([
                'password' => 'required',
                'confirm_password' => 'required',
                'email' => 'required'
            ]);  

        $password = $request->input('password');
        $id = $request->input('id');
        $email = $request->input('email');
   
        Users::where('id', $id)->update([
            'password' => Hash::make($password),
            'active' => 1
        ]);

        if(Auth::attempt(['email' => $email,'password' => $password], true)){

            return redirect('/');

        }else 
            return redirect('activate-account');

        
    }

    public function update(Request $request) {

    		$id = $request->input('id');

    		$update = Users::where('id', $id)->update([
    				'name' => $request->input('name'),
    				'email' => $request->input('email'),
    				'role' => $request->input('role')
    			]);

    		if ($update) 
    			return redirect('users');
    		 
    }
 
    public function delete(Request $request ) {
        if (Users::destroy($request->input('id'))) {
            return redirect()->back();
        }
    }

 

 
}
