<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_project extends Model
{
    protected $table = 'm_projects';
    protected $fillables = ['master_no', 'name', 'address','tele_no'];
}
