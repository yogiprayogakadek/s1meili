<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'id_role' => 1,
                'nama' => 'Administrator',
                'jenis_kelamin' => 1,
                'no_hp' => '0812341234',
                'alamat' => 'Jl. Sidakarya No. 1',
                'foto' => 'assets/uploads/users/default.png',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'id_role' => 2,
                'nama' => 'Kepala Sekolah',
                'jenis_kelamin' => 1,
                'no_hp' => '0812341234',
                'alamat' => 'Jl. Sidakarya',
                'foto' => 'assets/uploads/users/default.png',
                'email' => 'kepalasekolah@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'id_role' => 3,
                'nama' => 'Wakil Sarpras',
                'jenis_kelamin' => 1,
                'no_hp' => '0812341234',
                'alamat' => 'Jl. Sidakarya',
                'foto' => 'assets/uploads/users/default.png',
                'email' => 'wakilsarpras@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [
                'id_role' => 4,
                'nama' => 'Staf Administrasi',
                'jenis_kelamin' => 1,
                'no_hp' => '0812341234',
                'alamat' => 'Jl. Sidakarya',
                'foto' => 'assets/uploads/users/default.png',
                'email' => 'stafadministrasi@gmail.com',
                'password' => bcrypt('12345678'),
            ],
            [
                'id_role' => 5,
                'nama' => 'Bendahara',
                'jenis_kelamin' => 1,
                'no_hp' => '0812341234',
                'alamat' => 'Jl. Sidakarya',
                'foto' => 'assets/uploads/users/default.png',
                'email' => 'bendahara@gmail.com',
                'password' => bcrypt('12345678'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
