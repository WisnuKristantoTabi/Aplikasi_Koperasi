<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin_table';

    public function addadmin()
    {
        return $this->belongsTo('users');
    }
}
