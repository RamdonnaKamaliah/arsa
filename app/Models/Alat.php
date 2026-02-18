<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alat';
    
    protected $fillable = [
    'id_alat',
    'id_kategori',
    'nama_alat',
    'stok',
    'foto_alat',
    'kode_barang'
    ];

    public function kategori() {
        return $this->belongsTo(KategoriAlat::class, 'id_kategori');
    }

    public function detailPeminjaman() {
        return $this->hasMany(DetailPeminjaman::class, 'id_alat');
    }
}