<?php

namespace App\Http\Controllers;

use App\u_roles;
use App\User;
use App\u_user_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = u_roles::all();

        return view('u_user')->with(['roles' => $role]);;
    }

    public function create(){

        $result = User::all();

        return DataTables($result)->make(true);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'designation' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->pid = $request->pid;
                $user->designation = $request->designation;
                $user->password =  Hash::make($request->password);

                $user->save();

                $roles =$request->role_id;
                $users = $user->id;
                // save user role
                foreach( $roles as $role){

                    $user_role = new u_user_roles;
                    $user_role->user_id = $users;
                    $user_role->role_id = $role;

                    $user_role->save();

                }

                DB::commit();
                return response()->json(['db_success' => 'Added New Role']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }
    }

    public function show($id){

        $result['users'] = User::find($id);

        $result['u_user_roles'] = u_user_roles::select('role_id')->where(['user_id' => $id])->get();

        return response()->json($result);

    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'designation' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->pid = $request->pid;
                $user->phone = $request->phone;
                $user->designation = $request->designation;

                $user->save();

                $this->delete_roles( $user->id);

                $roles =$request->role_id;
                $users = $user->id;

                foreach( $roles as $role){

                    $user_role = new u_user_roles;
                    $user_role->user_id = $users;
                    $user_role->role_id = $role;

                    $user_role->save();

                }

                DB::commit();
                return response()->json(['db_success' => 'User Updated']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }

    }

    public function destroy($id){
        $result = User::destroy($id);
        $this->delete_roles($id);

        return response()->json($result);

    }

    public function delete_roles($id){
        u_user_roles::where(['user_id' => $id])->delete();
     }

}
