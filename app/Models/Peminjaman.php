<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'id_peminjaman',
        'id_user',
        'tanggal_pengambilan_rencana',
        'tanggal_pengembalian_rencana',
        'alasan_peminjaman',
        'status',
        'qr_token'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detail() {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id');
    }

    public function pengembalian() {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman', 'id');
    }
}