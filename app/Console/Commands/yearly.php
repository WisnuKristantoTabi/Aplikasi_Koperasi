<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class yearly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tanggal = Carbon::now();

        $sum=DB::table('aset_table')
        ->select(DB::raw('SUM(penyusutan) as total'))
        ->get();


        DB::table('detail_perkiraan_table')->where('id', '=', 12)->increment('jumlah_perkiraan', $sum[0]->total);

        DB::table('detail_perkiraan_table')->where('nomor_perkiraan', '=', "2.0.10")->increment('jumlah_perkiraan', $sum[0]->total);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        ["Akumulasi Penyusutan Peralatan", $tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') ,12, 0, $sum[0]->total, "d4c1d48a-f0f0-441c-85ca-859d6dc8b490"]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') ,22, $sum[0]->total, 0, "d4c1d48a-f0f0-441c-85ca-859d6dc8b490"]);

        echo "Berhasil\n";
    }
}
