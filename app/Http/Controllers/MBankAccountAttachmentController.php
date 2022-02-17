<?php

namespace App\Http\Controllers;

use App\m_bank_account;
use App\m_bank_account_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MBankAccountAttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('m_bank_account_attachment');
    }

    public function create(){

        $result = DB::table('m_bank_account_attachments')
                ->select('m_bank_account_attachments.*')
                ->get();

        return DataTables($result)->make(true);

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'document_main'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                if ($request->hasFile('document_path')) {

                    $file = $request->file('document_path');
                    $file_name =$file->getClientOriginalExtension();
                    $filename=time().'.'.$file_name;
                    $file->move(public_path('uploads\mbank_attachment'), $filename);

                    $upload1 = new m_bank_account_attachment;
                    $upload1->supplier_id = $request->supplier_id;;
                    $upload1->bank_id =$request->bank_id;
                    $upload1->document_main =  $request->document_main;
                    $upload1->document_path =  public_path("uploads\mbank_attachment/".$filename);
                    $upload1->save();

                }

                DB::commit();
                return response()->json(['db_success' => 'Added New Attachment']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }


    }

    public function show($id){

        $result = m_bank_account_attachment::find($id);

        return response()->json($result);

    }

    public function update(Request $request){


        $validator = Validator::make($request->all(), [
            'document_main'=>'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()->all()]);
        }else{
            try{
                DB::beginTransaction();

                $m_bank_account_attachment = m_bank_account_attachment::find($request->id);
                $m_bank_account_attachment->supplier_id = $request->supplier_id;
                $m_bank_account_attachment->bank_id = $request->bank_id;
                $m_bank_account_attachment->document_main = $request->document_main;

                $m_bank_account_attachment->save();


            DB::commit();
            return response()->json(['db_success' => 'Added New Attachment']);

            }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

        }


    }

    public function destroy($id){
        $result = m_bank_account_attachment::destroy($id);

        return response()->json($result);

    }

    public function showtable($id){
        $attchment = m_bank_account::where(['id'=> $id])->get();

        return view('m_bank_account_attachment')->with([
                                            'attchment' => $attchment[0] ]);

    }

    public function show_rates($id){

        $result = DB::table('m_bank_account_attachments')
        ->where('m_bank_account_attachments.bank_id', $id)
        ->select('m_bank_account_attachments.*')
        ->get();

        return DataTables($result)->make(true);
    }
}

