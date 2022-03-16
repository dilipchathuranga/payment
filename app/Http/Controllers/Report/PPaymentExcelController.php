<?php

namespace App\Http\Controllers\Report;

use App\Exports\P_Payment_Bill_Export;
use App\Http\Controllers\Controller;
use App\p_payment_bill;
use App\p_schedule;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class PPaymentExcelController extends Controller
{
    public function export(Request $request,$id)
    {
        $shedule=p_schedule::find($request->id);
        $ref=$shedule->refference_no;

        return Excel::download(new P_Payment_Bill_Export($request->id),$ref.'-'.date('Y-m-d:H-i-s').'.xlsx');
    }
}
