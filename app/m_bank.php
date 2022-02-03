<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_bank extends Model
{
    protected $table = 'm_banks'; 
    protected $fillables = ['code', 'name'];
}
