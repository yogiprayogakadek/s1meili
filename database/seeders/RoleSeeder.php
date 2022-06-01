<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            'Administrator', 'Kepala Sekolah', 'Wakil Sarpras', 'Staf Administrasi', 'Bendahara',
        ];

        $slug = [
            'admin', 'kepsek', 'wakil-sarpras', 'staf-administrasi', 'bendahara',
        ];

        foreach ($name as $key => $value) {
            Role::create([
                'nama' => $value,
                'slug' => $slug[$key],
            ]);
        }
    }
}
