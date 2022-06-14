<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->string('nip', 20);
            $table->string('nama_pegawai', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->char('no_telp', 16);
            $table->string('alamat', 100);
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('ruangan', 100);
            $table->string('jabatan', 100);
            $table->string('foto', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
};
