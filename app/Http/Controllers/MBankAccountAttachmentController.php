<?php

namespace App\Http\Controllers;

use App\m_bank_account;
use App\m_bank_account_attachment;
use App\m_branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DataTables;

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
                if($request->file('document_path')) {

                    $file = $request->file('document_path');
                    $file_name =$request->bank_id.'-'.$request->branch_id.'-'.$request->acc_id.'-'.date('m-d-Y_H-i-s').'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads\mbank_attachment'), $file_name);

                    $upload1 = new m_bank_account_attachment;
                    $upload1->supplier_id = $request->supplier_id;;
                    $upload1->bank_id =$request->bank_id;
                    $upload1->document_main =  $request->document_main;
                    $upload1->document_path =  public_path("uploads\mbank_attachment/".$file_name);
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

    public function destroy($id){


                $result=m_bank_account_attachment::find($id);
                $img=$result->document_path;
                if(File::exists($img)){
                    $delete= File::delete($img);
                }

                $acc_attachment=$result->delete();
                return response($acc_attachment);

    }

    public function show_table($id){
        $attchment = m_bank_account::where(['id'=> $id])->get();

        return view('m_bank_account_attachment')->with([
                                            'attchment' => $attchment[0] ]);
    }

    public function show_attachment($id){

        $result = m_bank_account_attachment::where('bank_id',$id);
        return DataTables($result)->make(true);

    }

    public function download($id){

        $agreement_uploads = m_bank_account_attachment::where(['id'=> $id])->pluck('document_path');

        $file= $agreement_uploads[0];

        $headers = array(
                  'Content-Type: application/pdf',
                );

        return Response()->download($file);
    }
}

