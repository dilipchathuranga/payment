<?php

namespace App\Http\Controllers;

use App\m_bank;
use App\m_bank_account;
use App\m_branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MBankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bank=m_bank::all();
        $branch=m_branch::all();
        return view('m_bank_account')->with(['banks' => $bank,'branches'=>$branch]);
    }

    public function create(){

        $result = DB::table('m_bank_accounts')
                            ->join('m_banks','m_bank_accounts.bank_id','=','m_banks.id')
                            ->join('m_branches','m_bank_accounts.branch_id','=','m_branches.id')
                            ->select('m_bank_accounts.*','m_banks.name as bank_name','m_branches.name as branch_name')
                            ->get();

        return DataTables($result)->make(true);

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'bank_id'=>'required',
            'branch_id' => 'required',
            'supplier_id' => 'required',
            'supplier_name'=>'required',
            'supplier_email' => 'required',
            'supplier_telephone' => 'required',
            'account_no'=>'required',
            'account_name' => 'required',
            'holder_nic' => 'required',

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
                $bank_account->supplier_email = $request->supplier_email;
                $bank_account->supplier_telephone = $request->supplier_telephone;
                $bank_account->account_no = $request->account_no;
                $bank_account->account_name = $request->account_name;
                $bank_account->holder_nic = $request->holder_nic;
                $bank_account->action_by = auth()->user()->id;
                $bank_account->status = 0;



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
            'supplier_email' => 'required',
            'supplier_telephone' => 'required',
            'account_no'=>'required',
            'account_name' => 'required',
            'holder_nic' => 'required',
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

    public function destroy($id){
        $result = m_bank_account::destroy($id);

        return response()->json($result);

    }
}
