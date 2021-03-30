<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPengarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pengarang', function (Blueprint $table) {
            $table->increments('id_pengarang');
            $table->string('NPWP', 255)->nullable();
            $table->string('NIK', 255)->nullable();
            $table->string('nm_pengarang', 255);
            $table->string('email', 255);
            $table->string('telepon', 255);
            $table->integer('tb_negara_id')->unsigned();
            $table->char('tb_kota_id', 4)->nullable();
            $table->char('tb_kecamatan_id', 7)->nullable();
            $table->char('tb_kelurahan_id', 10)->nullable();
            $table->bigInteger('kode_pos')->nullable();
            $table->integer('persen_royalti');
            $table->string('alamat', 255);
            $table->string('nama_rekening', 255);
            $table->string('bank_rekening', 255);
            $table->string('nomor_rekening', 255);
            $table->foreign('tb_negara_id')->references('id')->on('tb_negara');
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
        Schema::dropIfExists('tb_pengarang');
    }
}
