<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissoesTable extends Migration {

    public function up() {
        Schema::create('permissoes', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('permissao', 50)->comment('Permissão');
            $table->string('descricao', 255)->comment('Descrição');
            $table->boolean('permanente')->default(0)->comment('Se pode ser alterado');
        });
    }

    public function down() {
        Schema::drop('permissoes');
    }

}
