<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbIndukBuku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_induk_buku', function (Blueprint $table) {
            $table->char('kode_buku', 20)->primary();
            $table->char('isbn', 255)->nullable();
            $table->integer('tb_kategori_id')->unsigned();
            $table->integer('tb_pengarang_id')->unsigned();
            $table->integer('tb_penerbit_id')->unsigned();
            $table->integer('tb_distributor_id')->unsigned();
            $table->integer('tb_penerjemah_id')->unsigned()->nullable();
            $table->string('judul_buku', 255);
            $table->integer('tahun_terbit');
            $table->integer('harga_jual');
            $table->integer('berat');
            $table->tinyInteger('is_diskon');
            $table->string('deskripsi_buku', 1000);
            $table->text('cover');
            $table->text('link_cover');
            $table->foreign('tb_kategori_id')->references('id_kategori')->on('tb_kategori')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_pengarang_id')->references('id_pengarang')->on('tb_pengarang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_penerbit_id')->references('id_penerbit')->on('tb_penerbit')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_distributor_id')->references('id_distributor')->on('tb_distributor')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tb_penerjemah_id')->references('id_penerjemah')->on('tb_penerjemah')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_induk_buku');
    }
}
