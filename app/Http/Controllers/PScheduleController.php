<?php

namespace App\Http\Controllers;

use App\p_payment_bill;
use App\p_payment_bill_schedule;
use App\p_schedule;
use App\r_transaction_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('p_schedule');
    }

    public function create(){

        $result = p_schedule::all();

        return DataTables($result)->make(true);

    }
    public function view_payment_bill($id)
    {
        $result = DB::table('p_payment_bill_schedules')
                            ->join('p_payment_bills','p_payment_bills.id','=','p_payment_bill_schedules.payment_bill_id')
                            ->join('m_suppliers', 'p_payment_bills.bp_no', '=', 'm_suppliers.bp_no')
                            ->join('m_projects', 'p_payment_bills.master_no', '=', 'm_projects.master_no')
                            ->where('p_payment_bill_schedules.schedule_id',$id)
                            ->select('p_payment_bills.*',
                                'p_payment_bill_schedules.status AS bill_status',
                                'p_payment_bill_schedules.id AS schedule_id',
                                'p_payment_bill_schedules.schedule_id AS p_schedule_id',
                                'm_suppliers.name as supplier_name', 
                                'm_projects.name as project_name')
                            ->groupBy('p_payment_bill_schedules.id')
                            ->get();

            return DataTables($result)->make(true);

    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();

            $p_payment_bill_schedule = p_payment_bill_schedule::find($id);

            $schedule_delete = p_payment_bill_schedule::destroy($id);

            $payment_bill = p_payment_bill::find($p_payment_bill_schedule->payment_bill_id);
            $payment_bill->status = 1;
            $payment_bill->account_id = '';

            $payment_bill->save();


            DB::commit();
            return response()->json(['db_success' => 'Payment Bill Deleted']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }

    public function add_all_approve(Request $request)
    {
        try{
            
            DB::beginTransaction();
            
                for($i=0; $i< sizeof($request->acc_tables) ;$i++){
                    
                    $p_payment_bill_schedule = p_payment_bill_schedule::find($request->acc_tables[$i]);
                    $p_payment_bill_schedule->status = 'A';

                    $p_payment_bill_schedule->save();
                }

                $p_schedule=p_schedule::find($request->p_schedule_id);
                $p_schedule->status = 'A';

                $p_schedule->save();

            DB::commit();
            return response()->json(['db_success' => 'Payment Bill Schedule Status Added']);

        }catch(\Throwable $th){
                DB::rollback();
                throw $th;
                return response()->json(['db_error' =>'Database Error'.$th]);
            }

    }
    
    public function check_schedule($id){
        
        $result = DB::table("p_payment_bill_schedules")
                        ->where("p_payment_bill_schedules.schedule_id", $id)
                        ->where("p_payment_bill_schedules.status", "P")
                        ->get();
                        
                        
        if($result->count() == 0){
            return response()->json(false);
        }else{
            return response()->json(true);
        }
        
    }

    public function pay($id)
    {
        try{
            DB::beginTransaction();

            $p_schedule=p_schedule::find($id);
            $p_schedule->status = 'C';

            $p_schedule->save();

            $p_payment_bill_schedule = DB::table('p_payment_bill_schedules')
                                                ->where('p_payment_bill_schedules.schedule_id',$id)
                                                ->update(['p_payment_bill_schedules.status'=>'C']);

            $payment_bill_schedules = DB::table('p_payment_bill_schedules')
                                                ->where('p_payment_bill_schedules.schedule_id',$id)
                                                ->join('p_payment_bills','p_payment_bills.id','=','p_payment_bill_schedules.payment_bill_id')
                                                ->update(['p_payment_bills.status'=>'3']);

            $transaction_log = DB::table('p_payment_bill_schedules')
                                                ->where('p_payment_bill_schedules.schedule_id',$id)
                                                ->join('p_payment_bills','p_payment_bills.id','=','p_payment_bill_schedules.payment_bill_id')
                                                ->select('p_payment_bills.id')
                                                ->get();

            $transaction=$transaction_log[0];

            $r_transaction_log = new r_transaction_log;
            $r_transaction_log->bill_id = $transaction->id;
            $r_transaction_log->date = date('Y-m-d H:i:s');
            $r_transaction_log->status = 3; // paid
            $r_transaction_log->action_by = auth()->user()->id;

            $r_transaction_log->save();


            DB::commit();
            return response()->json(['db_success' => 'Bills Paid']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }
}
