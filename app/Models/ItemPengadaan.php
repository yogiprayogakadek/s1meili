<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPengadaan extends Model
{
    use HasFactory;

    protected $table = 'item_pengadaan';
    protected $primaryKey = 'id_item_pengadaan';
    protected $guarded = ['id_item_pengadaan'];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'id_pengadaan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
