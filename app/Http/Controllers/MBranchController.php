<?php

namespace App\Http\Controllers;
use App\m_bank;
use App\m_branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DataTables;

class MBranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bank = DB::table('m_banks')
                        ->select('m_banks.*')
                        ->where('can_delete','=','0')
                        ->get();

        return view('m_branch')->with(['banks' => $bank]);
    }

    public function create(){

        $result = m_branch::where('is_active','=','1');

        return DataTables::of($result)
                        ->addColumn('bank_name', function(m_branch $branch){
                            return $branch->bank->name;
                        })
                        ->make(true);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'bank_id'=>'required',
            'code' => 'required',
            'name' => 'required',

        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $branch = new m_branch;
                $branch->bank_id = $request->bank_id;
                $branch->code = $request->code;
                $branch->name = $request->name;
                $branch->is_active = 1;


                $branch->save();

                DB::commit();
                return response()->json(['db_success' => 'Added New branch']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }


    }

    public function show($id){
        $result = m_branch::find($id);

        return response()->json($result);

    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'bank_id'=>'required',
            'code' => 'required',
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $branch = m_branch::find($request->id);
                $branch->bank_id = $request->bank_id;
                $branch->code = $request->code;
                $branch->name = $request->name;

                $branch->save();

                DB::commit();
                return response()->json(['db_success' => 'Branch Updated']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }

    }

    public function destroy(Request $request){
        try{
            DB::beginTransaction();

            $branch = m_branch::find($request->id);
            $branch->is_active = 0;

            $branch->save();

            DB::commit();
            return response()->json(['db_success' => 'Branch Updated']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }

    public function get_by_bank_id($id){

        $result = m_branch::where('bank_id', $id)->get();

        return response()->json($result);

    }
}
