<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class LaporanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('detail_perkiraan_table')
        ->join('perkiraan_table', 'perkiraan_table.id', '=', 'detail_perkiraan_table.perkiraan_table_id')
        ->select('nama_perkiraan_detail', 'jumlah_perkiraan', 'perkiraan_table_id','nomor_perkiraan','nama_perkiraan')
        ->get();
        return $data;
    }


    public function headings(): array
    {
        return [
            'Nomor Perkiraan',
            'Nama Perkiraan',
            'Saldo'
        ];
    }


}
