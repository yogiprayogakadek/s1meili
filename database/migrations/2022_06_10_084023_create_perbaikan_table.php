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
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->id('id_perbaikan');
            $table->foreignId('id_user')->references('id_user')->on('users')->onDelete('cascade')->comment('user yang memasukkan data');
            $table->string('nomor_laporan', 50);
            $table->string('pemohon', 100);
            $table->string('jabatan_pemohon', 100);
            $table->date('tanggal_perbaikan');
            $table->json('item_perbaikan');
            $table->enum('status_perbaikan', ['Ditolak', 'Diproses', 'Diterima'])->default('Diproses');
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
        Schema::dropIfExists('perbaikan');
    }
};
