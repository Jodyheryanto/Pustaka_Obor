<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbReturPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_retur_penjualan', function (Blueprint $table) {
            // $table->increments('id_retur_penjualan');
            // $table->integer('tb_penjualan_buku_id')->unsigned();
            // $table->integer('qty');
            // $table->tinyInteger('status_retur_penjualan');
            // $table->string('bukti_retur_pejualan', 255);
            // $table->foreign('tb_penjualan_buku_id')->references('id_penjualan_buku')->on('tb_penjualan_buku');
            // $table->timestamps();

            $table->increments('id_retur_penjualan');
            $table->integer('tb_penjualan_buku_id')->unsigned();
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('discount');
            $table->integer('total_harga');
            $table->integer('total_non_diskon');
            $table->foreign('tb_penjualan_buku_id')->references('id_penjualan_buku')->on('tb_penjualan_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->string('note', 1000);
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
        Schema::dropIfExists('tb_retur_penjualan');
    }
}
