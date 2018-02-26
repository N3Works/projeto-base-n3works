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
            $table->integer('permanente')->default(0)->comment('Se pode ser alterado');
        });

        DB::table('permissoes')->insert([
            [
                'id' => '1', 
                'permanente' => '0',
                'permissao' => 'MENUS_LISTAR',
                'descricao' => 'Mostrar a listagem dos menus.',
            ],
            [
                'id' => '2', 
                'permanente' => '1',
                'permissao' => 'PERMISSOES_LISTAR',
                'descricao' => 'Se deve monstra a lista de permissões',
            ],
            [
                'id' => '3', 
                'permanente' => '1',
                'permissao' => 'USERS_LISTAR',
                'descricao' => 'Se deve monstra a lista de usuários',
            ],
        ]);
    }

    public function down() {
        Schema::drop('permissoes');
    }

}
