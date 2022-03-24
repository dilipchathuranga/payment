<?php

namespace App\Http\Controllers;

use App\u_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class URolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('u_roles');
    }

    public function create(){

        $result = u_roles::all();

        return DataTables($result)->make(true);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $type = new u_roles;
                $type->description = $request->description;

                $type->save();

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
        $result = u_roles::find($id);

        return response()->json($result);

    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $type = u_roles::find($request->id);
                $type->description = $request->description;

                $type->save();

                DB::commit();
                return response()->json(['db_success' => 'Role Updated']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }

    }

    public function destroy($id){

        $result = u_roles::destroy($id);

        return response()->json($result);

    }

}
