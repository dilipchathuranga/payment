<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class u_user_roles extends Model
{
    protected $table = 'u_user_roles';
    protected $fillables = ['user_id','role_id'];
}
