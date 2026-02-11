<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $fillable = [
        'id_pengembalian',
        'id_peminjaman',
        'tanggal_pengembalian_sebenarnya',
        'status_pelanggaran',
        'kondisi_kembali',
        'catatan',
    ];
}