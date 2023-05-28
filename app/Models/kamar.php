<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kamar extends Model
{
    use HasFactory;
    protected $table = 'kamars';
    protected $primarykey = 'id_kamar';
    protected $fillable = ['total_pesan', 'type_kamar','max', 'foto', 'status_kamar', 'deskripsi', 'harga', 'created_at', 'updated_at'];
}
