<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_branch extends Model
{
    protected $table = 'm_branches'; 
    protected $fillables = ['bank_id', 'code', 'name'];
}
