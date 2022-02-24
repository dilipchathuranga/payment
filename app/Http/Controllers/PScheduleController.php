<?php

namespace App\Http\Controllers;

use App\p_payment_bill;
use App\p_payment_bill_schedule;
use App\p_schedule;
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

        $result = p_schedule::where('status', 'P')->get();

        return DataTables($result)->make(true);

    }
    public function view_payment_bill($id)
    {
        $result = DB::table('p_payment_bill_schedules')
                ->where('p_payment_bill_schedules.schedule_id',$id)
                ->join('p_payment_bills','p_payment_bills.id','=','p_payment_bill_schedules.payment_bill_id')
                ->select('p_payment_bills.*','p_payment_bill_schedules.status AS bill_status','p_payment_bill_schedules.id AS schedule_id')
                ->get();

        return DataTables($result)->make(true);

    }
    public function approve(Request $request)
    {
        try{
            DB::beginTransaction();

            $p_payment_bill_schedule = p_payment_bill_schedule::find($request->id);
            $p_payment_bill_schedule->status = 'A';

            $p_payment_bill_schedule->save();

            DB::commit();
            return response()->json(['db_success' => 'Payment Bill Schedule Status Added']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

    }

    public function pending(Request $request)
    {
        try{
            DB::beginTransaction();

            $p_payment_bill_schedule = p_payment_bill_schedule::find($request->id);
            $p_payment_bill_schedule->status = 'P';

            $p_payment_bill_schedule->save();

            DB::commit();
            return response()->json(['db_success' => 'Payment Bill Schedule Status Added']);

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
            return response()->json(['db_error' =>'Database Error'.$th]);
        }

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
}
