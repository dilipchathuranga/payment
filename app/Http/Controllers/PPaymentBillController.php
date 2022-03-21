<?php

namespace App\Http\Controllers;

use App\m_project;
use App\m_supplier;
use App\p_payment_bill;
use App\p_payment_bill_schedule;
use App\p_schedule;
use App\r_transaction_log;
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
        $projects = m_project::all();
        $suppliers = m_supplier::all();

        return view('p_payment_bill')->with([ 'projects' => $projects,
                                              'suppliers' => $suppliers]);
    }

    public function bulk_bill_receive(Request $request){

        $bill_ids = $request->bill_id;

        try{
            DB::beginTransaction();

            foreach($bill_ids as $value){

                $bill = p_payment_bill::find($value);
                $bill->status = 1; //received

                $bill->save();

                //tranfer log
                $r_transaction_log = new r_transaction_log;
                $r_transaction_log->bill_id = $value;
                $r_transaction_log->date = date('Y-m-d H:i:s');
                $r_transaction_log->status = 1; // Received

                $r_transaction_log->save();

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

                 //tranfer log
                 $r_transaction_log = new r_transaction_log;
                 $r_transaction_log->bill_id = $id;
                 $r_transaction_log->date = date('Y-m-d H:i:s');
                 $r_transaction_log->status = 1; // Received

                 $r_transaction_log->save();

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

                //tranfer log
                $r_transaction_log = new r_transaction_log;
                $r_transaction_log->bill_id = $bills[$i]['bill_id'];
                $r_transaction_log->date = date('Y-m-d H:i:s');
                $r_transaction_log->status = 2; // scheduled

                $r_transaction_log->save();
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

        $result = DB::table('p_payment_bills')
                    ->join('m_suppliers', 'p_payment_bills.bp_no', '=', 'm_suppliers.bp_no')
                    ->join('m_projects', 'p_payment_bills.master_no', '=', 'm_projects.master_no')
                    ->where('p_payment_bills.status', 0)
                    ->select('p_payment_bills.*', 'm_suppliers.name as supplier_name', 'm_projects.name as project_name')
                    ->groupBy('p_payment_bills.id')
                    ->get();

        return response()->json($result);

    }

    public function pending_payment_bills_datatable(Request $request){

        $master_no = $request->master_no;
        $bp_no = $request->bp_no;
        $module = $request->module;
        $invoice_month = $request->invoice_month;

        $result = DB::table('p_payment_bills')
            ->join('m_suppliers', 'p_payment_bills.bp_no', '=', 'm_suppliers.bp_no')
            ->join('m_projects', 'p_payment_bills.master_no', '=', 'm_projects.master_no')
            ->where('p_payment_bills.status', 0);

        if($master_no != null){
            $result= $result->where('p_payment_bills.master_no', '=', $master_no);
        }

        if($bp_no != null){
            $result= $result->where('p_payment_bills.bp_no', '=', $bp_no);
        }

        if($module != null){
            $result= $result->where('p_payment_bills.module', '=', $module);
        }

        if($invoice_month != null){
            $result= $result->where('p_payment_bills.invoice_date', '=', $invoice_month);
        }

        $result = $result->select('p_payment_bills.*', 'm_suppliers.name as supplier_name', 'm_projects.name as project_name')
                ->groupBy('p_payment_bills.id')
                ->get();

        return DataTables($result)->make(true);

    }

    public function received_payment_bills(){

        $result = DB::table('p_payment_bills')
                    ->join('m_suppliers', 'p_payment_bills.bp_no', '=', 'm_suppliers.bp_no')
                    ->join('m_projects', 'p_payment_bills.master_no', '=', 'm_projects.master_no')
                    ->where('p_payment_bills.status', 1)
                    ->select('p_payment_bills.*', 'm_suppliers.name as supplier_name', 'm_projects.name as project_name')
                    ->groupBy('p_payment_bills.id')
                    ->get();

        return response()->json($result);

    }

    public function received_payment_bills_datatable(Request $request){

        $master_no = $request->master_no;
        $bp_no = $request->bp_no;
        $module = $request->module;
        $invoice_month = $request->invoice_month;

        $result = DB::table('p_payment_bills')
            ->join('m_suppliers', 'p_payment_bills.bp_no', '=', 'm_suppliers.bp_no')
            ->join('m_projects', 'p_payment_bills.master_no', '=', 'm_projects.master_no')
            ->where('p_payment_bills.status', 1);

        if($master_no != null){
            $result= $result->where('p_payment_bills.master_no', '=', $master_no);
        }

        if($bp_no != null){
            $result= $result->where('p_payment_bills.bp_no', '=', $bp_no);
        }

        if($module != null){
            $result= $result->where('p_payment_bills.module', '=', $module);
        }

        if($invoice_month != null){
            $result= $result->where('p_payment_bills.invoice_date', '=', $invoice_month);
        }

        $result = $result->select('p_payment_bills.*', 'm_suppliers.name as supplier_name', 'm_projects.name as project_name')
                ->groupBy('p_payment_bills.id')
                ->get();

        return DataTables($result)->make(true);

    }

    public function priority(Request $request)
    {
        try{
            DB::beginTransaction();
    
            $p_payment_bill = p_payment_bill::find($request->id);
            $p_payment_bill->priority = $request->data;
    
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



