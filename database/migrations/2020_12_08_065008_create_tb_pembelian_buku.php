<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPembelianBuku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pembelian_buku', function (Blueprint $table) {
            $table->increments('id_pembelian_buku');
            $table->char('tb_induk_buku_kode_buku', 20);
            $table->integer('tb_supplier_id')->unsigned();
            $table->integer('qty');
            $table->integer('harga_beli_satuan');
            $table->integer('total_harga');
            $table->date('tgl_ppn');
            $table->string('note', 1000);
            $table->tinyInteger('status_pembelian');
            $table->foreign('tb_induk_buku_kode_buku')->references('kode_buku')->on('tb_induk_buku')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_supplier_id')->references('id_supplier')->on('tb_supplier')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_pembelian_buku');
    }
}
