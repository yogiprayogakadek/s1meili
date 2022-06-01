<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $table = 'pengadaan';
    protected $primaryKey = 'id_pengadaan';
    protected $guarded = ['id_pengadaan'];

    public function item_pengadaan()
    {
        return $this->hasMany(ItemPengadaan::class, 'id_pengadaan');
    }
}
