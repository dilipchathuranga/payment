<?php

namespace App\Http\Controllers;

use App\p_payment_bill;
use App\p_payment_bill_schedule;
use App\p_schedule;
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

    public function bill_receive($id){

        try{
            DB::beginTransaction();

                $bill = p_payment_bill::find($id);
                $bill->status = 1; //received

                $bill->save();

            DB::commit();
            return response()->json(['db_success' => 'Bill Received']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }

    public function create_schedule(Request $request){

        $bills = $request->bills;
        $date = $request->date;
        $refference_no = $request->refference_no;

        try{
            DB::beginTransaction();

            //new schedule creating
            $schedule = new p_schedule;
            $schedule->date = $date;
            $schedule->refference_no = $refference_no;
            $schedule->status = "P";
            $schedule->save();


            for($i=0;$i<sizeof($bills);$i++){
                //payment bill status update
                $bill = p_payment_bill::find($bills[$i]['bill_id']);
                $bill->account_id = $bills[$i]['account_id'];
                $bill->status = 2; //scheduled
                $bill->save();

                // new payment bill schedule
                $payment_schedule = new p_payment_bill_schedule;
                $payment_schedule->payment_bill_id = $bills[$i]['bill_id'];
                $payment_schedule->schedule_id = $schedule->id;
                $payment_schedule->account_id = $bills[$i]['account_id'];
                $payment_schedule->status = "P";
                $payment_schedule->save();
            }



            DB::commit();
            return response()->json(['db_success' => 'Schedule Created']);

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

        $project_id = $request->project_id;
        $supplier_id = $request->supplier_id;
        $module = $request->module;
        $invoice_month = $request->invoice_month;

        $result = DB::table('p_payment_bills')
            ->where('p_payment_bills.status', 0);

        if($project_id != null){
            $result= $result->where('p_payment_bills.project_id', '=', $project_id);
        }

        if($supplier_id != null){
            $result= $result->where('p_payment_bills.supplier_id', '=', $supplier_id);
        }

        if($module != null){
            $result= $result->where('p_payment_bills.module', '=', $module);
        }

        if($invoice_month != null){
            $result= $result->where('p_payment_bills.invoice_date', '=', $invoice_month);
        }

        $result = $result->select('p_payment_bills.*')
                ->get();

        return DataTables($result)->make(true);

    }

    public function received_payment_bills(){

        $result = p_payment_bill::where('status', '1')->get();

        return response()->json($result);

    }

    public function received_payment_bills_datatable(Request $request){

        $project_id = $request->project_id;
        $supplier_id = $request->supplier_id;
        $module = $request->module;
        $invoice_month = $request->invoice_month;

        $result = DB::table('p_payment_bills')
            ->where('p_payment_bills.status', 1);

        if($project_id != null){
            $result= $result->where('p_payment_bills.project_id', '=', $project_id);
        }

        if($supplier_id != null){
            $result= $result->where('p_payment_bills.supplier_id', '=', $supplier_id);
        }

        if($module != null){
            $result= $result->where('p_payment_bills.module', '=', $module);
        }

        if($invoice_month != null){
            $result= $result->where('p_payment_bills.invoice_date', '=', $invoice_month);
        }

        $result = $result->select('p_payment_bills.*')
                ->get();

        return DataTables($result)->make(true);

    }

    public function default(Request $request)
    {
        try{
            DB::beginTransaction();

            $p_payment_bill = p_payment_bill::find($request->id);
            $p_payment_bill->priority = 'D';

            $p_payment_bill->save();

            DB::commit();
            return response()->json(['db_success' => 'Payment Bill Priority Added']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }

    public function hold(Request $request)
    {
        try{
            DB::beginTransaction();

            $p_payment_bill = p_payment_bill::find($request->id);
            $p_payment_bill->priority = 'H';

            $p_payment_bill->save();

            DB::commit();
            return response()->json(['db_success' => 'Payment Bill Priority Added']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }

    public function agent(Request $request)
    {
        try{
            DB::beginTransaction();

            $p_payment_bill = p_payment_bill::find($request->id);
            $p_payment_bill->priority = 'U';

            $p_payment_bill->save();

            DB::commit();
            return response()->json(['db_success' => 'Payment Bill Priority Added']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }
}
