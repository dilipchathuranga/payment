<?php

namespace App\Http\Controllers;
use App\p_payment_bill;
use App\r_transaction_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PPaymentSearchController extends Controller
{
    public function index()
    {
        return view('p_payment_bill_search');
    }
    public function create()
    {
        $p_payment_bill = p_payment_bill::all();

        return DataTables($p_payment_bill)->make(true);
    }

    public function tranfer_log($id)
    {
        $result = DB::table('r_transaction_logs')
                        ->leftJoin('users','users.id','r_transaction_logs.action_by')
                        ->where('r_transaction_logs.bill_id',$id)
                        ->orderBy('r_transaction_logs.status','ASC')
                        ->select('users.name as user_name','r_transaction_logs.*')
                        ->get();

        return DataTables($result)->make(true);
    }
}
