<?php

namespace App\Http\Controllers;

use App\m_project;
use App\m_supplier;
use App\p_payment_bill;
use App\r_transaction_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PPaymentSearchController extends Controller
{
    public function index()
    {
        $projects = m_project::all();
        $suppliers = m_supplier::all();

        return view('p_payment_bill_search')->with([ 'projects' => $projects,
                                                    'suppliers' => $suppliers]);
                                                    
    }
    public function create()
    {
        $result = DB::table('p_payment_bills')
                    ->join('m_suppliers', 'p_payment_bills.bp_no', '=', 'm_suppliers.bp_no')
                    ->join('m_projects', 'p_payment_bills.master_no', '=', 'm_projects.master_no')
                    ->select('p_payment_bills.*', 'm_suppliers.name as supplier_name', 'm_projects.name as project_name')
                    ->groupBy('p_payment_bills.id')
                    ->get();

        return DataTables($result)->make(true);
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
