<?php

namespace App\Http\Controllers;
use App\p_payment_bill;

use Illuminate\Http\Request;

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
}
