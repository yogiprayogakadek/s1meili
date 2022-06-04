<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanHistori extends Model
{
    use HasFactory;

    protected $table = 'pengadaan_histori';
    protected $primaryKey = 'id_pengadaan_histori';
    protected $guarded = ['id_pengadaan_histori'];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'id_pengadaan');
    }
}
