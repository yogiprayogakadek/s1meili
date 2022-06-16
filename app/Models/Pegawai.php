<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $guarded = ['id_pegawai'];
    
    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class, 'id_pegawai');
    }
}
