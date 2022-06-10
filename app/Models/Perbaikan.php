<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;

    protected $table = 'perbaikan';
    protected $primaryKey = 'id_perbaikan';
    protected $guarded = ['id_perbaikan'];

    public function perbaikan_histori()
    {
        return $this->hasMany('App\Models\PerbaikanHistori', 'id_perbaikan', 'id_perbaikan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
