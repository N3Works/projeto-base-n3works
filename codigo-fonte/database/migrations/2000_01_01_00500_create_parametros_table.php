<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosTable extends Migration {

    public function up() {
        Schema::create('parametros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 60);
            $table->integer('parametro_editavel')->unsigned();
            $table->string('descricao')->nullable();
            $table->integer('status')->unsigned();
            $table->enum('tipo', ['integer', 'text', 'dropdown', 'boolean'])->default('text');
            $table->string('valor', 255);
        });
    }

    public function down() {
        Schema::drop('parametros');
    }

}
