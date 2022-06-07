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
        Schema::create('item_pengadaan', function (Blueprint $table) {
            $table->id('id_item_pengadaan');
            $table->foreignId('id_pengadaan')->references('id_pengadaan')->on('pengadaan')->onDelete('cascade');
            $table->foreignId('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
            $table->integer('harga_satuan');
            $table->integer('jumlah_barang');
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
        Schema::dropIfExists('item_pengadaan');
    }
};
