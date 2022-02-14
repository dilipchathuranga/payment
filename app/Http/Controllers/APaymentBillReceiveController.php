<?php

namespace App\Http\Controllers;

use App\p_payment_bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class APaymentBillReceiveController extends Controller
{
    public function store(Request $request){
        
        try{
            DB::beginTransaction();

            $payment = new p_payment_bill;
            $payment->module = $request->module;
            $payment->bill_id = $request->bill_id;
            $payment->invoice_date = $request->invoice_date;
            $payment->project_id = $request->project_id;
            $payment->project_name = $request->project_name;
            $payment->supplier_id = $request->supplier_id;
            $payment->supplier_name = $request->supplier_name;
            $payment->bill_refference = $request->bill_refference;
            $payment->pic_no = $request->pic_no;
            $payment->amount = $request->amount;
            $payment->received_date = date('Y-m-d');
            $payment->status = 0; // pending
            $payment->priority = 'D';

            $payment->save();

            DB::commit();
            return response()->json(['db_success' => 'Added New Bill']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }
        
    }
}
