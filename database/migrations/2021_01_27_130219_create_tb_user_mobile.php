<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbUserMobile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_user_mobile', function (Blueprint $table) {
            $table->increments('id_user_mobile');
            $table->string('password', 255);
            $table->string('email', 120);
            $table->string('no_tlp', 12);
            $table->string('nama', 255);
            $table->string('alamat', 500);
            $table->string('NPWP', 255);
            $table->string('NIK', 255);
            $table->string('avatar_user', 255);
            $table->text('link_avatar_user');
            $table->string('login_with', 100);
            $table->tinyInteger('is_block');
            $table->integer('is_login');
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
        Schema::dropIfExists('tb_user_mobile');
    }
}
