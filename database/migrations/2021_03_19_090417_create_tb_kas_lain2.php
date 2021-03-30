<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKasLain2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kas_lain2', function (Blueprint $table) {
            $table->increments('id');
            $table->char('tb_data_account_id', 20)->nullable();
            $table->date('tgl_transaksi');
            $table->string('note', 1000);
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->char('id_faktur', 10)->nullable();
            $table->tinyInteger('is_bayar')->nullable();
            $table->foreign('tb_data_account_id')->references('id_account')->on('tb_data_account')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tb_kas_lain2');
    }
}
