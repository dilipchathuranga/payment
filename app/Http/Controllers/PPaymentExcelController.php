<?php

namespace App\Http\Controllers;

use App\Exports\p_payment_billExport;
use App\p_payment_bill;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class PPaymentExcelController extends Controller
{
    public function export(Request $request,$id)
    {
        return Excel::download(new p_payment_billExport($request->id),'payment.xlsx');
    }
}
