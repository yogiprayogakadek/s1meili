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
        Schema::table('item_pengadaan', function (Blueprint $table) {
            $table->string('satuan_barang', 50)->after('jumlah_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_pengadaan', function (Blueprint $table) {
            $table->dropColumn('satuan_barang');
        });
    }
};
