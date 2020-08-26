<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class monthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monthly';

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
        $shu = DB::table('detail_perkiraan_table')
        ->select('jumlah_perkiraan')
        ->where("id" ,"=", "18")
        ->first();

        $v = DB::table('variabel_table')
        ->select('persen')
        ->where("id" ,"=", "2")
        ->orWhere("id" ,"=", "3")
        ->get();
        $pemb = ( $shu->jumlah_perkiraan * ($v[0]->persen / 100) ) + ( $shu->jumlah_perkiraan * ($v[1]->persen / 100) ) ;
        $jshu = $shu->jumlah_perkiraan - ($pemb * (10/100));

        $modal=DB::table('detail_perkiraan_table')
        ->select(DB::raw('SUM(jumlah_perkiraan) as modal'))
        ->where("id" ,">", "14")
        ->where("id" ,"<", "18")
        ->get();

        $aktiva = DB::select("SELECT sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END) AS aktiva FROM detail_perkiraan_table",[1]);
        $utang = DB::select("SELECT sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END) AS utang FROM detail_perkiraan_table",[4]);
        $pendapatan = DB::select("SELECT sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END) AS pendapatan FROM detail_perkiraan_table",[5]);

        $kas = DB::table('detail_perkiraan_table')
        ->select("jumlah_perkiraan")
        ->where("id" ,"=", "1")
        ->first();

        $tanggal = Carbon::now();

        DB::insert('insert into ukur (tanggal, kas, shu, modal, aktiva, utang, pendapatan) values (?, ?, ?, ?, ?, ?, ?)',
        [$tanggal, $kas->jumlah_perkiraan, $jshu, $modal[0]->modal, $aktiva[0]->aktiva, $utang[0]->utang, $pendapatan[0]->pendapatan]);
        echo "Berhasil\n";
    }
}
