<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class p_payment_bill extends Model
{
    protected $table = 'p_payment_bills';
    protected $fillables = ['module','bill_id','invoice_date','bill_refference','pic_no','amount','received_date','status','priority'];
}
