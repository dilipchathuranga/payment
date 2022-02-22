<?php

namespace App\Http\Controllers;

use App\m_bank;
use App\m_bank_account;
use App\m_branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\Http;

class MBankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $banks = m_bank::all();
        $branches = m_branch::all();

       return view('m_bank_account')->with(['banks' => $banks,
                                            'branches' => $branches]);

    }

    public function create(){

        $result = m_bank_account::where('is_active','=','1');

        return DataTables::of($result)
                        ->addColumn('bank_name', function(m_bank_account $bank_account){
                            return $bank_account->bank->name;
                        })
                        ->addColumn('branch_name', function(m_bank_account $bank_account){
                            return $bank_account->branch->name;
                        })
                        ->make(true);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'bank_id'=>'required',
            'branch_id' => 'required',
            'supplier_id' => 'required',
            'supplier_name'=>'required',
            'account_no'=>'required',
            'account_name' => 'required'

        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $bank_account = new m_bank_account;
                $bank_account->bank_id = $request->bank_id;
                $bank_account->branch_id = $request->branch_id;
                $bank_account->supplier_id = $request->supplier_id;
                $bank_account->supplier_name = $request->supplier_name;
                $bank_account->bp_no = $request->bp_no;
                $bank_account->supplier_email = $request->supplier_email;
                $bank_account->supplier_telephone = $request->supplier_telephone;
                $bank_account->account_no = $request->account_no;
                $bank_account->account_name = $request->account_name;
                $bank_account->holder_nic = $request->holder_nic;
                $bank_account->action_by = auth()->user()->id;
                $bank_account->status = 0;
                $bank_account->is_active = 1;

                $bank_account->save();

                DB::commit();
                return response()->json(['db_success' => 'Added New Bank Account']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }


    }

    public function show($id){
        $result = m_bank_account::find($id);

        return response()->json($result);

    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'bank_id'=>'required',
            'branch_id' => 'required',
            'supplier_id' => 'required',
            'supplier_name'=>'required',
            'account_no'=>'required',
            'account_name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $bank_account = m_bank_account::find($request->id);
                $bank_account->bank_id = $request->bank_id;
                $bank_account->branch_id = $request->branch_id;
                $bank_account->supplier_id = $request->supplier_id;
                $bank_account->supplier_name = $request->supplier_name;
                $bank_account->bp_no = $request->bp_no;
                $bank_account->supplier_email = $request->supplier_email;
                $bank_account->supplier_telephone = $request->supplier_telephone;
                $bank_account->account_no = $request->account_no;
                $bank_account->account_name = $request->account_name;
                $bank_account->holder_nic = $request->holder_nic;
                $bank_account->action_by = auth()->user()->id;
                $bank_account->status = 0;

                $bank_account->save();

                DB::commit();
                return response()->json(['db_success' => 'Bank Account Updated']);

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

                $bank_account = m_bank_account::find($request->id);
                $bank_account->is_active = 0;

                $bank_account->save();

                DB::commit();
                return response()->json(['db_success' => 'Bank Account Deleted']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }
    }

    public function get_supplier($id){

        $supplier_response = Http::get('http://fin.maga.engineering/api/get_supplier/'.$id, [
            'api_token' => 'MAGA_AUHT_00001'
        ]);

       return $supplier_response;

    }


    public function get_status(Request $request){
        try{
            DB::beginTransaction();

            $bank_account = m_bank_account::find($request->id);
            $bank_account->status = $request->data;

            $bank_account->save();

            DB::commit();
            return response()->json(['db_success' => 'Bank Status Added']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }
    }

    public function get_accounts($id){

        $result = DB::table('m_bank_accounts')
                    ->join('m_banks', 'm_bank_accounts.bank_id', '=', 'm_banks.id')
                    ->join('m_branches', 'm_bank_accounts.branch_id', '=', 'm_branches.id')
                    ->select('m_bank_accounts.*', 'm_banks.name as bank_name', 'm_branches.name as branch_name')
                    ->get();

        return response()->json($result);
    }

}
