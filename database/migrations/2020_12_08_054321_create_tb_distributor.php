<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDistributor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_distributor', function (Blueprint $table) {
            $table->increments('id_distributor');
            $table->string('NPWP', 255)->nullable();
            $table->string('nm_distributor', 255);
            $table->string('email', 255);
            $table->string('telepon', 255);
            $table->char('tb_kota_id', 4);
            $table->char('tb_kecamatan_id', 7);
            $table->char('tb_kelurahan_id', 10);
            $table->bigInteger('kode_pos');
            $table->string('alamat', 255);
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
        Schema::dropIfExists('tb_distributor');
    }
}
