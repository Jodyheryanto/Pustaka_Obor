<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pelanggan', function (Blueprint $table) {
            $table->increments('id_pelanggan');
            $table->string('nama', 255)->nullable();
            $table->char('tb_kota_id', 4);
            $table->char('tb_kecamatan_id', 7);
            $table->char('tb_kelurahan_id', 10);
            $table->string('alamat', 255);
            $table->string('telepon', 255);
            $table->string('email', 255);
            $table->date('tanggal_lahir');
            $table->foreign('tb_kota_id')->references('id')->on('tb_kota');
            $table->foreign('tb_kecamatan_id')->references('id')->on('tb_kecamatan');
            $table->foreign('tb_kelurahan_id')->references('id')->on('tb_kelurahan');
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
        Schema::dropIfExists('tb_pelanggan');
    }
}
