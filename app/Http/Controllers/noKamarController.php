<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\noKamar;
use Illuminate\Support\Facades\DB;

class noKamarController extends Controller
{
    function getAllKamar()
    {
        $get = noKamar::orderBy('no_kamar', 'asc')->get();
        return response()->json($get);
    }

    function selectKamar($id)
    {
        $get = noKamar::where('id_no_kamar', $id)->get();
        return response()->json($get);
    }

    function getKamar()
    {
        $get = noKamar::where('status', 'kosong')->get();
        return response()->json($get);
    }

    function addNumber(Request $req)
    {
        $add = noKamar::create([
            'id_transaksi' => 'null',
            'lantai' => $req->lantai,
            'no_kamar' => $req->no_kamar,
            'status' => 'kosong',
        ]);

        if ($add) {
            return response()->json([
                'msg' => 'Berhasil Menambah Nomor',
                'result' => $add,
            ], 200);
        }
        return response()->json(['msg' => 'Gagal Menambah kamar']);
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

    function updateKamar(Request $req, $id)
    {
        $update = noKamar::where('id_no_kamar', $id)->update([
            'no_kamar' => $req->no_kamar,
            'lantai' => $req->lantai,
            'status' => $req->status
        ]);

        if ($update) {
            return response()->json([$update], 200);
        }
        return response()->json(['msg' => 'Gagal Update Kamar'], 500);
    }

    function deleteKamar($id)
    {
        $delete = noKamar::where('id_no_kamar', $id)->delete();
        if ($delete) {
            return response()->json(['msg' => 'Berhasil Hapus Kamar'], 200);
        }
        return response()->json(['msg' => 'Gagal hapus kamar'], 500);
    }
}
