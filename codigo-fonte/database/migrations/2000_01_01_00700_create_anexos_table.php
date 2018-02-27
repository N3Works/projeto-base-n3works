<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnexosTable extends Migration {

    public function up() {
        Schema::create('anexos', function (Blueprint $table) {
            $table->increments("id");
            $table->string("filename", 255);
            $table->string("name", 100);
            $table->string("size");
            $table->string("mime_type", 255);
            $table->string("nome_fantasia", 255);
            $table->string("descricao", 255);
                
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('anexos');
    }

}
