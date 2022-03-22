<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_supplier extends Model
{
    protected $table = 'm_suppliers';
    protected $fillables = ['bp_no','name','address','email','tele_no'];
}
