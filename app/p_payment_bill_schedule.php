<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class p_payment_bill_schedule extends Model
{
    protected $table = 'p_payment_bill_schedules';
    protected $fillables = ['payment_bill_id', 'schedule_id', 'status'];
}
