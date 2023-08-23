<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class noKamar extends Model
{
    use HasFactory;
    protected $table = 'no_kamar';
    protected $primarykey = 'id_no_kamar';
    protected $fillable = [
        'id_transaksi',
        'no_kamar',
        'status'
    ];

    public $timestamps = false;
}
