<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();



        $schedule->call(function () {


        $tanggal = Carbon::now();
        //penyusutan peralatan
        $sum=DB::table('aset_table')
        ->select(DB::raw('SUM(penyusutan) as total'))
        ->get();


        DB::table('detail_perkiraan_table')->where('id', '=', 12)->increment('jumlah_perkiraan', $sum[0]->total);

        DB::table('detail_perkiraan_table')->where('nomor_perkiraan', '=', "2.0.10")->increment('jumlah_perkiraan', $sum[0]->total);

        DB::insert('insert into jurnal_umum_table (keterangan,tanggal,periode_table_id) values (?, ?, ?)',
        ["Akumulasi Penyusutan Peralatan", $tanggal,getIdLatest('periode_table')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id, detail_perkiraan_id , debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') ,12, 0, $sum[0]->total, Session::get('id_admin')]);

        DB::insert('insert into detail_jurnal_umum (jurnal_umum_table_id,detail_perkiraan_id, debit, kredit, id_admin) values (?, ?, ? , ?, ?)',
        [getIdLatest('jurnal_umum_table') ,22, $sum[0]->total, 0, Session::get('id_admin')]);

        })->yearly();


        $schedule->call(function () {

        $shu = DB::select("(SELECT ((sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END))".
        " - (sum(CASE WHEN perkiraan_table_id = ? THEN jumlah_perkiraan ELSE 0 END))) AS shu FROM detail_perkiraan_table)",[6,7]);

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
        [$tanggal, $kas->jumlah_perkiraan, $shu[0]->shu, $modal[0]->modal, $aktiva[0]->aktiva, $utang[0]->utang, $pendapatan[0]->pendapatan]);

        DB::table('detail_perkiraan_table')
        ->where("id","=","18")
        ->update(['jumlah_perkiraan' => $shu[0]->shu]);

    })->monthlyOn(1, '10:00');




    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
