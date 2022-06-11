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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id('id_maintenance');
            $table->foreignId('id_user')->references('id_user')->on('users')->onDelete('cascade')->comment('user yang memasukkan data');
            $table->string('nomor_laporan', 50);
            $table->string('pemohon', 100);
            $table->string('jabatan_pemohon', 100);
            $table->date('tanggal_maintenance');
            $table->json('item_maintenance');
            $table->enum('status_maintenance', ['Ditolak', 'Diproses', 'Diterima'])->default('Diproses');
            $table->enum('kategori_maintenance', ['Perawatan dan Perbaikan', 'Kerusakan']);
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
        Schema::dropIfExists('maintenances');
    }
};
