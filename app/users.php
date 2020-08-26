<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class users extends Model
{


    protected $table = 'users';

    public function adduser()
   {
       return $this->hasMany('admin_table');
   }

}
