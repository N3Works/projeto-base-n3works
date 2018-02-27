<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration {

    public function up() {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('header', 40)->comment('Titulo');
            $table->string('controller', 255)->comment('Controlador');
            $table->string('action', 255)->nullable()->comment('Ação');
            $table->string('icon', 255)->comment('Icone');
            $table->integer('order')->unsigned()->default(1)->comment('Ordenador');
            $table->integer('parent')->unsigned()->nullable()->default(0)->comment('Menu Pai');
            
            $table->integer('permissao_id')->unsigned()->nullable();
            $table->foreign('permissao_id')->references('id')->on('permissoes');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('menus');
    }
}
