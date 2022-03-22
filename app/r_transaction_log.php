<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class r_transaction_log extends Model
{
    protected $table = 'r_transaction_logs';
    protected $fillables = ['bill_id', 'date','status'];
}
