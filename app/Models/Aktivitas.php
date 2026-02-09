<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Aktivitas extends Model
{
    protected $table = 'aktivitas';

    protected $fillable = [
        'id_log',
        'id_user',
        'aksi',
        'entitas',
        'keterangan'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

   public static function simpanLog($aksi, $entitas, $keterangan = null)
    {
        return self::create([
            'id_log'     => (string) Str::uuid(),
            'id_user'    => auth()->id(),
            'aksi'       => $aksi,
            'entitas'    => $entitas,
            'keterangan' => $keterangan,
        ]);
    }
    
    
}