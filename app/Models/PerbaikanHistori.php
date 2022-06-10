<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerbaikanHistori extends Model
{
    use HasFactory;

    protected $table = 'perbaikan_histori';
    protected $primaryKey = 'id_perbaikan_histori';
    protected $guarded = ['id_perbaikan_histori'];

    public function perbaikan()
    {
        return $this->belongsTo('App\Models\Perbaikan', 'id_perbaikan', 'id_perbaikan');
    }
}
