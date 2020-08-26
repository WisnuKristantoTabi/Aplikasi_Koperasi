<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DetailPerkiraanModel extends Model
{
    protected $table = ['detail_perkiraan_table'];

    public function addDetailPerkiraan($nama_perkiraan , $jumlah_perkiraan , $perkiraan_table_id, $nomor_perkiraan  )
    {
        $time =  now();
        DB::table('detail_perkiraan_table')->insert(
            ['nama_perkiraan' => $nama_perkiraan,
            'jumlah_perkiraan' => $jumlah_perkiraan,
            'perkiraan_table_id' => $perkiraan_table_id,
            'nomor_perkiraan' => $nomor_perkiraan,
            'created_at' => $time ,
            'updated_at' => $time
            ]);
    }

    public function showList()
    {
        // code...
    }
}
