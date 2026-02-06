<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAlat extends Model
{
    protected $fillable = [
        'id_kategori',
        'nama_kategori'
    ];

    public function alat() {
        return $this->belongsTo(Alat::class);
    }
}