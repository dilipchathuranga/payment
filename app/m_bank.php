<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_bank extends Model
{
    protected $table = 'm_banks'; 
    protected $fillables = ['code', 'name'];

    public function branch(){

        return $this->hasMany(m_branch::class, 'bank_id', 'id');

    }

    public function bank_account(){

        return $this->hasMany(m_bank_account::class, 'bank_id', 'id');

    }
}
