<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class p_schedule extends Model
{
    protected $table = 'p_schedules';
    protected $fillables = ['date', 'refference_no'];
}
