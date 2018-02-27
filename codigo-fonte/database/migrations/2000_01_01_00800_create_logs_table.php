<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{

    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments("id");
            $table->char("acao", 6);
            $table->integer("usuario_id")->unsigned();
            $table->string("usuario_nome", 100);
            $table->string("entidade", 20);
            $table->string("data");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('logs');
    }

}
