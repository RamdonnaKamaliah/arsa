<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    protected $fillable = [
        'id_detail_peminjaman',
        'id_peminjaman',
        'id_alat',
        'jumlah',
        'kondisi_keluar'
    ];

    public function alat() {
        return $this->belongsTo(Alat::class, 'id_alat');
    }
}