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
        Schema::create('pengadaan', function (Blueprint $table) {
            $table->id('id_pengadaan');
            $table->foreignId('id_user')->references('id_user')->on('users')->onDelete('cascade')->comment('user yang memasukkan data');
            $table->string('pemohon', 100);
            $table->string('jabatan_pemohon', 100);
            $table->date('tanggal_pengadaan');
            $table->date('tanggal_penerimaan');
            $table->string('nomor_laporan', 50);
            $table->integer('biaya_pengadaan');
            $table->text('keterangan');
            $table->string('nota', 100)->nullable();
            $table->enum('status_pengadaan', ['Ditolak', 'Diproses', 'Diterima'])->default('Diproses');
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
        Schema::dropIfExists('pengadaan');
    }
};
