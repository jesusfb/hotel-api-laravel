<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\noKamar;
use Illuminate\Support\Facades\DB;

class noKamarController extends Controller
{
    function getKamar()
    {
        $get = noKamar::where('status','kosong')->get();
        return response()->json($get);
    }

    function chooseKamar(Request $req, $noKamar)
    {
        // $getBanyakKamar = DB::table('transaksis')->where('id_transaksi', $req->id_transaksi)->select('jumlah_kamar')->first();
        // if ($getBanyakKamar == $req->jumlah_kamar) {
        //     return response()->json(['msg' => 'No kamar sudah terisi semua'], 400);
        // }

        $post = noKamar::where('no_kamar', $noKamar)->update([
            'id_transaksi' => $req->id_transaksi,
            'status' => 'dipakai'
        ]);

        if ($post) {
            return response()->json(['msg' => 'Berhasil memilih kamar', 'result' => 'dipakai', 'tes aja' => $req->id_transaksi], 200);
        }
        return response()->json(['msg' => 'Ada yang error coba cek dulu'], 500);
    }
}
