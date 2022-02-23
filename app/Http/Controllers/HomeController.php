<?php

namespace App\Http\Controllers;

use App\m_bank_account;
use App\p_payment_bill;
use App\p_schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pending_bills = p_payment_bill::where('status', 0)->get();
        $received_bills = p_payment_bill::where('status', 1)->get();
        $schedules = p_schedule::all();
        $bank_accounts = m_bank_account::all();

        return view('home')->with([
                                'pending_bills' => $pending_bills->count(),
                                'received_bills' => $received_bills->count(),
                                'schedules' => $schedules->count(),
                                'bank_accounts' => $bank_accounts->count()
                            ]);
    }

    public function bill_session(Request $request){

        Session::put(['bill_session' => $request->session]);

    }

    
    public function get_session(){

        $result = array();

        $result['bill_session'] = Session::get('bill_session');

        return response()->json($result);

    }
}
