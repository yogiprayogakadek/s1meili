<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceHistori extends Model
{
    use HasFactory;

    protected $table = 'maintenance_histori';
    protected $primaryKey = 'id_maintenance_histori';
    protected $guarded = ['id_maintenance_histori'];
    
    public function maintenance()
    {
        return $this->belongsTo('App\Models\Maintenance', 'id_maintenance');
    }
}
