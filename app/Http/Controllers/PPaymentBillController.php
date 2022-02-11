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

    public function pending_payment_bills_datatable(Request $request){

        $result = p_payment_bill::where('status', '0')->get();

        return DataTables($result)->make('true');

    }
    
    public function pending_payment_bills_json(Request $request){

        $result = p_payment_bill::where('status', '0')->get();

        return response()->json($result);

    }
    
    public function recieved_payment_bills(Request $request){

        $result = p_payment_bill::where('status', '1')->get();


        return DataTables($result)->make('true');

    }

}
