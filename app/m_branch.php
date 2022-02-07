<?php

namespace App;

use App\m_bank;
use Illuminate\Database\Eloquent\Model;

class m_branch extends Model
{
    protected $table = 'm_branches'; 
    protected $fillables = ['bank_id', 'code', 'name'];

    public function bank(){

        return $this->belongsTo(m_bank::class, 'bank_id', 'id');

    }

    public function bank_account(){

        return $this->hasMany(m_bank_account::class, 'bank_id', 'id');

    }
}
