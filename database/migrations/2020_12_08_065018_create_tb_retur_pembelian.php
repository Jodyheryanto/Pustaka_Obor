<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbReturPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_retur_pembelian', function (Blueprint $table) {
            $table->increments('id_retur_pembelian');
            $table->integer('tb_pembelian_buku_id')->unsigned();
            $table->integer('qty');
            $table->integer('discount');
            $table->tinyInteger('status_retur_pembelian');
            $table->string('note', 1000);
            $table->foreign('tb_pembelian_buku_id')->references('id_pembelian_buku')->on('tb_pembelian_buku')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_retur_pembelian');
    }
}
