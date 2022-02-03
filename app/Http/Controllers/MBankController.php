<?php

namespace App\Http\Controllers;
use App\m_bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('m_bank');
    }

    public function create(){

        $result = DB::table('m_banks')
                            ->select('m_banks.*')
                            ->get();

        return DataTables($result)->make(true);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $type = new m_bank;
                $type->name = $request->name;
                $type->code = $request->code;


                $type->save();

                DB::commit();
                return response()->json(['db_success' => 'Added New Bank']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }


    }

    public function show($id){
        $result = m_bank::find($id);

        return response()->json($result);

    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $type = m_bank::find($request->id);
                $type->name = $request->name;
                $type->code = $request->code;

                $type->save();

                DB::commit();
                return response()->json(['db_success' => 'Bank Updated']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }

    }

    public function destroy($id){
        $result = m_bank::destroy($id);

        return response()->json($result);

    }

}
