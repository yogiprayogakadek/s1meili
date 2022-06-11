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
        Schema::create('maintenance_histori', function (Blueprint $table) {
            $table->id('id_maintenance_histori');
            $table->foreignId('id_maintenance')->references('id_maintenance')->on('maintenances')->onDelete('cascade')->comment('maintenance yang dikelola');
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
        Schema::dropIfExists('maintenance_histori');
    }
};
