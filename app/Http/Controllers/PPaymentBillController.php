<?php

namespace App\Http\Controllers;

use App\p_payment_bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PPaymentBillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('p_payment_bill');
    }

    public function bulk_bill_receive(Request $request){
        
        $bill_ids = $request->bill_id;

        try{
            DB::beginTransaction();

            foreach($bill_ids as $value){

                $bill = p_payment_bill::find($value);
                $bill->status = 1; //received

                $bill->save();
            }

            DB::commit();
            return response()->json(['db_success' => 'Bills Received']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }


    }

    public function pending_payment_bills(){

        $result = p_payment_bill::where('status', '0')->get();

        return response()->json($result);

    }

    public function pending_payment_bills_datatable(Request $request){

        $result = p_payment_bill::where('status', '0')->get();

        return DataTables($result)->make('true');

    }
    
    
    public function received_payment_bills_datatable(Request $request){

        $result = p_payment_bill::where('status', '1')->get();


        return DataTables($result)->make('true');

    }

}
