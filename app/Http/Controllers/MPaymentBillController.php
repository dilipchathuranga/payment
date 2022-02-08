<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MPaymentBillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('m_payment_bill');
    }
}
