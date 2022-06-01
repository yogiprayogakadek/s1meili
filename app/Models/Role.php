<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id_role'];
    protected $primaryKey = 'id_role';
    protected $table = 'role';

    public function user()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
