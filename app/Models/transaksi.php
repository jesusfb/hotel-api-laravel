<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksis';
    protected $primarykey = 'id_transaksi';
    protected $fillable = ['nama_tamu','no_kamar','email','tgl_pesan','check_in','check_out','id_kamar','id_fasilitas','jumlah_kamar','total_harga','jumlah','status','created_at','updated_at'];
}
