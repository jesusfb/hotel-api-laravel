<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Models\kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class TransaksiController extends Controller
{
    public function gettransaksi()
    {
        $transaksi = transaksi::get();
        return response()->json($transaksi);
    }
    public function pilihtransaksi($id)
    {
        $transaksi = transaksi::where('nama_tamu', $id)->join('kamars', 'kamars.id_kamar', '=', 'transaksis.id_kamar')->first();
        return response()->json($transaksi);
    }
    public function pilihtransaksibyid($id)
    {
        $transaksi = transaksi::where('id_transaksi', $id)->join('kamars', 'kamars.id_kamar', '=', 'transaksis.id_kamar')->first();
        return response()->json($transaksi);
    }
    public function notconfirmed()
    {
        $transaksi = transaksi::where('status', 'dipesan')->get();
        return response()->json($transaksi);
    }
    public function confirmed()
    {
        $transaksi = transaksi::where('status', 'dikonfirmasi')->get();
        return response()->json($transaksi);
    }
    public function ongoing()
    {
        $transaksi = transaksi::where('status', 'dipakai')->get();
        return response()->json($transaksi);
    }
    public function dibersihkan()
    {
        $transaksi = transaksi::where('status', 'dibersihkan')->get();
        return response()->json($transaksi);
    }
    public function history()
    {
        $history = transaksi::where('status','selesai')->get();
        return response()->json($history);
    }
    public function createtransaksi(Request $req)
    {

        $validator = Validator::make($req->all(), [
            // 'nama_tamu' => 'required',
            'nama_tamu' => 'required',
            'email' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            // 'tgl_pesan' => 'required',
            'id_kamar' => 'required',
            'jumlah_kamar' => 'required',
            // 'harga' => 'required',
            // 'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->tojson());
        }

        $tgl_pesan = Carbon::now();
        // $id_kamar = $req->input('id_kamar');
        // $jumlah = $req->input('jumlah_kamar');
        // $kamar = kamar::where('id_kamar',$id_kamar)->first();
        // $get_harga = $kamar -> harga; 
        // $total_harga = $get_harga * $jumlah;

        $createtransaksi = transaksi::create([
            'nama_tamu' => $req->input('nama_tamu'),
            'email' => $req->input('email'),
            'tgl_pesan' => $tgl_pesan,
            'check_in' => $req->input('checkin'),
            'check_out' => $req->input('checkout'),
            'id_kamar' => $req->input('id_kamar'),
            'id_fasilitas' => null,
            'jumlah_kamar' => $req->input('jumlah_kamar'),
            'total_harga' => $req->input('harga'),
            'status' => 'dipesan',
        ]);

        $updatestatuskamar = kamar::where('id_kamar', '=', $req->input('id_kamar'))->update([
            'status_kamar' => 'dipesan'
        ]);

        if ($createtransaksi && $updatestatuskamar) {
            return response()->json(['Message' => 'Sukses tambah transaksi']);
        } else {
            return response()->json(['Message' => 'Gagal tambah transaksi']);
        }
    }

    public function updatetransaksi(Request $r, $id)
    {
        $update = transaksi::where('id_transaksi', $id)->update([
            'nama_tamu' => $r->input('nama_tamu'),

            'email' => $r->input('email'),
            'tgl_pesan' => $r->input('tgl_pesan'),
            'check_in' => $r->input('check_in'),
            'check_out' => $r->input('check_out'),
            'id_kamar' => $r->input('id_kamar'),
            'id_fasilitas' => $r->input('id_fasilitas'),
            'jumlah_kamar' => $r->input('jumlah_kamar'),
            'total_harga' => $r->input('harga'),
            'status' => $r->input('status'),
        ]);

        if ($update) {
            return response()->json(['Message' => 'Sukses update transaksi']);
        } else {
            return response()->json(['Message' => 'Gagal update transaksi']);
        }
    }
    public function deletetransaksi($id)
    {
        $delete = transaksi::where('id_transaksi', $id)->delete();
        if ($delete) {
            return response()->json('Berhasil menghapus data');
        } else {
            return response()->json('Gagal menghapus data');
        }
    }
    public function konfirmasi(Request $req, $id)
    {
        $transaksi = transaksi::where('id_transaksi', $id)->update([
            // 'no_kamar' => $req->input('no_kamar'),
            'status' => 'dikonfirmasi'
        ]);

        return response()->json([
            'Message' => 'Berhasil Konfirmasi'
        ]);
    }
    public function checkin(Request $req, $id)
    {
        $update = transaksi::where('id_transaksi', $id)->update([
            'no_kamar' => $req->input('no_kamar'),
            'status' => 'dipakai'
        ]);

        return response()->json([
            'Message' => 'Sukses Check-In',
            'Result' => $update
        ]);
    }
    public function checkout($id, $id_kamar)
    {
        $checkout = transaksi::where('id_transaksi', $id)->update([
            'status' => 'dibersihkan'
        ]);

        $kamar = kamar::where('id_kamar', $id_kamar)->update([
            'status_kamar' => 'dibersihkan'
        ]);

        return response()->json([
            'Message' => 'Sukses Check-Out',
            'checkout' => $checkout,
            'kamar' => $kamar,
        ]);
    }
    public function kamardone($id, $id_kamar)
    {
        $update = transaksi::where('id_transaksi', $id)->update([
            'status' => 'selesai'
        ]);

        $kamar = kamar::where('id_kamar', $id_kamar)->update([
            'status_kamar' => 'kosong'
        ]);

        return response()->json([
            'Message' => 'Sukses selesai booking',
            'booking' => $update,
            'kamar' => $kamar
        ]);
    }
}
