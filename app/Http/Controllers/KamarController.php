<?php

namespace App\Http\Controllers;

use App\Models\kamar;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KamarController extends Controller
{
    public function getkamar()
    {
        $getkamar = kamar::get();
        return response()->json($getkamar);
    }
    public function kamarbyid($id)
    {
        $pilihkamar = kamar::where('id_kamar', $id)->get();
        return response()->json($pilihkamar);
    }
    public function createkamar(Request $req)
    {

        // $foto = $req->input('file');
        // $nama_file = $foto->getClientOriginalName();
        // $foto->move('public/images/' . $nama_file);

        $createkamar = kamar::create([
            // 'nomor_kamar' => $req->input('nomor_kamar'),
            'type_kamar' => $req->input('type_kamar'),
            'deskripsi' => $req->input('deskripsi'),
            'max' => $req->input('max'),
            'foto' => $req->input('foto'),
            'harga' => $req->input('harga'),
            'nomor_kamar' => $req->input('nomor_kamar'),
            
        ]);


        if ($createkamar) {
            return response()->json(['message' => 'Berhasil tambah kamar' , 'hasil' => $createkamar]);
        } else {
            return response('Gagal');
        }
    }
    public function updatekamar(Request $req, $id)
    {
        $validator = Validator::make($req -> all(),[
            // 'nomor_kamar' => 'required',
            // 'type_kamar' => 'required',
        ]);

        if($validator -> fails()){
            return response()->json($validator -> errors()->tojson());
        }

        $update = kamar::where('id_kamar',$id)->update([
            // 'nomor_kamar' => $req->input('nomor_kamar'),
            'type_kamar' => $req->input('type_kamar'),
            'deskripsi' => $req->input('deskripsi'),
            'max' => $req->input('max'),
            'harga' => $req->input('harga'),
            'foto' => $req->input('foto'),
            'status_kamar' => $req->input('status_kamar'),
        ]);

        if($update){
            return response()->json(['Message' => 'Sukses update kamar']);
        } else {
            return response()->json('Gagal Update Kamar');
        }
    }

    public function deletekamar($id)
    {
            $delete = kamar::where('id_kamar',$id)->delete();
            if($delete){
                return response()->json(['Message' => 'Sukses delete kamar']);
            } else {
                return response()->json(['Message' => 'Gagal delete kamar']);
            }
    }

    public function uploadFoto(Request $req, $id)
    {
        $imageName = time().'.'.$req->foto->extension();

        $req->foto->move(public_path('images'), $imageName);

        $update = kamar::where('id_kamar' , $id)->update([
            'foto' => $imageName
        ]);

        return response()->json([
            'Message' => 'Sukses upload foto',
            'result' => $update
        ]);
    }
}
