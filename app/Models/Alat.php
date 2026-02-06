<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $fillable = [
    'id_alat',
    'kategori_alat_id',
    'nama_alat',
    'stok'
    ];

    public function kategori() {
        return $this->belongsTo(KategoriAlat::class, 'kategori_alat_id');
    }
}