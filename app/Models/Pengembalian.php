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

     protected $casts = [
        'tanggal_pengembalian_sebenarnya' => 'datetime',
        'tanggal_penggantian' => 'datetime',
        'status_pelanggaran' => 'boolean'
    ];

     public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function detailPeminjaman()
{
    return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman');
}

    
}