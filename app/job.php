<?php

namespace App;
use Illuminate\Support\Facades\DB;

DB::insert('insert into periode_table (nama_periode) values (?)',['test']);
echo "Tst";


 ?>
