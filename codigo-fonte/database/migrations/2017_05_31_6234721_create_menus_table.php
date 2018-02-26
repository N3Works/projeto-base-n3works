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
            $table->string('action', 255)->comment('Ação');
            $table->string('icon', 255)->comment('Icone');
            $table->integer('order')->unsigned()->default(1)->comment('Ordenador');
            $table->integer('parent')->unsigned()->nullable()->default(0)->comment('Menu Pai');
            $table->timestamps();
        });
		
        $datetime = date('Y-m-d H:i:s');
        DB::table('menus')->insert([
            [
                'id' => '1', 
                'header' => 'Página Inicial', 
                'controller' => 'default',
                'action' => 'index',
                'icon' => 'home',
                'parent' => '0',
                'order' => '1',
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => '2', 
                'header' => 'Configuração', 
                'controller' => 'menus',
                'action' => 'index',
                'icon' => 'cogs',
                'parent' => '0',
                'order' => '1',
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => '3', 
                'header' => 'Parâmetros', 
                'controller' => 'parametros',
                'action' => 'index',
                'icon' => 'list',
                'parent' => '2',
                'order' => '2',
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => '4', 
                'header' => 'Menus', 
                'controller' => 'menus',
                'action' => 'index',
                'icon' => 'list',
                'parent' => '2',
                'order' => '1',
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => '5', 
                'header' => 'Permissões', 
                'controller' => 'permissoes',
                'action' => 'index',
                'icon' => 'list',
                'parent' => '2',
                'order' => '3',
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => '6', 
                'header' => 'Usuários', 
                'controller' => 'users',
                'action' => 'index',
                'icon' => 'user',
                'parent' => '0',
                'order' => '2',
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
        ]);
    }

    public function down() {
        Schema::drop('menus');
    }

}
