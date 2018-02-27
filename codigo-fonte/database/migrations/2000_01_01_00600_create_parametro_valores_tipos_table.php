<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametroValoresTiposTable extends Migration {

    public function up() {
        Schema::create('parametro_valores_tipos', function (Blueprint $table) {
            $table->increments("id");
            $table->string("value", 255);
            $table->string("header", 255);
            $table->integer("parametro_id")->unsigned();
            $table->foreign('parametro_id')->references('id')->on('parametros');
        });
    }

    public function down() {
        Schema::drop('parametro_valores_tipos');
    }

}
