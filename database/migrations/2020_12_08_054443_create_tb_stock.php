<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_stock', function (Blueprint $table) {
            $table->char('tb_induk_buku_kode_buku', 20);
            $table->integer('tb_lokasi_id')->unsigned();
            $table->foreign('tb_induk_buku_kode_buku')->references('kode_buku')->on('tb_induk_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_lokasi_id')->references('id_lokasi')->on('tb_lokasi')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('qty');
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
        Schema::dropIfExists('tb_stock');
    }
}
