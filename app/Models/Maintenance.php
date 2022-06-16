<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenances';
    protected $primaryKey = 'id_maintenance';
    protected $guarded = ['id_maintenance'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function maintenance_histori()
    {
        return $this->hasOne('App\Models\MaintenanceHistori', 'id_maintenance', 'id_maintenance');
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'id_pegawai');
    }
}
