<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissoesPerfisTable extends Migration {

    public function up() {
        Schema::create('permissoes_perfis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permissao_id')->unsigned();
            $table->integer('perfil_id')->unsigned();
            $table->foreign('perfil_id')->references('id')->on('perfis');
            $table->foreign('permissao_id')->references('id')->on('permissoes');
        });
    }

    public function down() {
        Schema::drop('permissoes_perfis');
    }

}
