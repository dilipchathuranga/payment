<?php

namespace App\Exports;

use App\p_payment_bill;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class p_payment_billExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $result = DB::table('p_payment_bill_schedules')
                    ->where('p_payment_bill_schedules.schedule_id',$this->id)
                    ->join('p_payment_bills','p_payment_bills.id','=','p_payment_bill_schedules.payment_bill_id')
                    ->join('m_bank_accounts','m_bank_accounts.id','=','p_payment_bills.account_id')
                    ->join('m_banks','m_bank_accounts.bank_id','=','m_banks.id')
                    ->join('m_branches','m_bank_accounts.branch_id','=','m_branches.id')
                    ->select('m_bank_accounts.account_name','m_bank_accounts.account_no','m_banks.code as bank_code','m_branches.code as branch_code','p_payment_bills.amount','p_payment_bills.bill_refference')
                    ->get();

                    return $result;
    }

    public function headings(): array
    {
        return [
            'Account Name',
            'Account No',
            'Bank Code',
            'Branch Code',
            'Amount',
            'Bill Reference',
        ];
    }
}
