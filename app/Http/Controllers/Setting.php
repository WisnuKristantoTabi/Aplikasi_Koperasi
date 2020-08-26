<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Setting extends Controller
{
    public function showVariabel()
    {
        $variabel = DB::table('variabel_table')->get();
    	return view('/layout/setting', ['variabel' => $variabel]);
    }

    public function editVariabel(Request $request)
    {
        DB::table('variabel_table')->where('id',$request->id)->update([
            'persen' => $request->persen
        ]);
        return redirect('/setting')->with('success','Variabel Berhasil Di Ganti');
    }
}
