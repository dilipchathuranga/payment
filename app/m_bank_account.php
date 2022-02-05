<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_bank_account extends Model
{
    protected $table = 'm_bank_accounts'; 
    protected $fillables = ['bank_id', 'branch_id', 'supplier_id', 'account_no'];

    public function bank(){

        return $this->belongsTo(m_bank::class, 'bank_id', 'id');

    }

    public function branch(){

        return $this->belongsTo(m_branch::class, 'branch_id', 'id');

    }
}
