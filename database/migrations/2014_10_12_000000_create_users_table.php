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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->foreignId('id_role')->references('id_role')->on('role')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama', 50);
            $table->boolean('jenis_kelamin');
            $table->string('no_hp', 20);
            $table->string('alamat', 100);
            $table->string('foto', 100);
            $table->string('email', 50);
            $table->string('password', 100);
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
        Schema::dropIfExists('users');
    }
};
