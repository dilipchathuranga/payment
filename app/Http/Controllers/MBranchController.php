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
        $bank=m_bank::all();
        return view('m_branch')->with(['banks' => $bank]);
    }

    public function create(){

        $result = DB::table('m_branches')
                            ->join('m_banks','m_branches.bank_id','=','m_banks.id')
                            ->select('m_branches.*','m_banks.name as bank_name')
                            ->get();

        return DataTables($result)->make(true);

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

    public function destroy($id){
        $result = m_branch::destroy($id);

        return response()->json($result);

    }
}
