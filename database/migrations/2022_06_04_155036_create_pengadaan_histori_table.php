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
        Schema::create('pengadaan_histori', function (Blueprint $table) {
            $table->id('id_pengadaan_histori');
            $table->foreignId('id_pengadaan')->references('id_pengadaan')->on('pengadaan')->onDelete('cascade');
            $table->enum('approve_kepala_sekolah', ['Ditolak', 'Diproses', 'Diterima'])->nullable();
            $table->enum('approve_wakil_sarpras', ['Ditolak', 'Diproses', 'Diterima'])->nullable();
            $table->date('tanggal_approve_kepala_sekolah')->nullable();
            $table->date('tanggal_approve_wakil_sarpras')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pengadaan_histori');
    }
};
