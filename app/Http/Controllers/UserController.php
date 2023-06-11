<?php

namespace App\Http\Controllers;

use App\Models\User;
// use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use PDO;

class UserController extends Controller
{
    public function getuser()
    {
        $getuser = User::get();
        return response($getuser);
    }

    public function getsatuuser($id)
    {
        $getuser = User::where('id', $id)->get();
        return response($getuser);
    }

    public function createuser(Request $req)
    {
        $validasi = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'level' => 'required',
        ]);

        if ($validasi->fails()) {
            return response()->json($validasi->errors()->tojson(), 422);
        }

        $createuser = User::create([
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
            'level' => $req->input('level'),
        ]);

        return response()->json($createuser);
    }

    public function updateuser(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:3',
            'level' => 'required',
        ]);

        if (!$validator) {
            return response()->json($validator->errors()->tojson());
        }

        $update = User::where('id', $id)->update([
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->get('password')),
            'level' => $req->input('level')
        ]);

        $data = [
            'id' => $id,
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
            'level' => $req->input('level')
        ];

        return response()->json($data);
    }
    public function deleteuser($id)
    {
        $delete = User::where('id', $id)->delete();
        if ($delete) {
            return response()->json(['msg' => 'Success delete user']);
        }
        return response()->json(['msg' => 'Failed delete user'], 500);
    }

    // public function tes(Request $req)
    // {
    //     $jumlah = $req->input('jumlah');
    //     $harga = Transaksi::join('barang', 'barang.id_barang', '=', 'transaksi.id_barang')->select('harga')->get();
    //     $total = $jumlah * $harga;
    //     return response()->json(['Total harga' => $total]);
    // }
}
