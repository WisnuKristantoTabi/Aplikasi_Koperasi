<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Notif extends Controller
{
    public function countUnseen (Request $request){
        if ($request->id) {
            $output="";
            //"76a66e9e-40e5-4386-b70d-4f9ec47c35e5"
            //admin
            //d4c1d48a-f0f0-441c-85ca-859d6dc8b490

            //87c9bf34-8440-45ae-853b-1b1034b57da9
            $data=DB::table('notifikasi')
            ->where('member_table_id',"=",$request->id)
            ->where('status',"=",1)
            ->count();

            $output.='<span class="badge badge-danger badge-counter">'.$data.'</span>';

            return response()->json(["count"=>$data, "notif"=>$output]);
        }else {
            abort(404);
        }

    }

    public function index(Request $request)
    {
        //76a66e9e-40e5-4386-b70d-4f9ec47c35e5
        $data=DB::table('notifikasi')
        ->where('member_table_id',"=",$request->id)
        ->orderBy("id","desc")
        ->paginate(10);

        return view("/layout/notif/index",["data"=>$data]);
    }

    public function show(Request $request)
    {
        DB::table('notifikasi')
        ->where('id',"=",$request->id)
        ->update(["status"=>2]);

        $data=DB::table('notifikasi')
        ->where('id',"=",$request->id)
        ->first();

        return view("/layout/notif/message",["data"=>$data]);
    }

    public function delete(Request $request)
    {
        DB::table('notifikasi')
        ->where('id',"=",$request->id)
        ->delete();

        Session::flash('success', "Berhasil Dihapus");
        return redirect()->back();
    }




}
