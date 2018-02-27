<?php
use Illuminate\Database\Migrations\Migration;

class InsertMenusTable extends Migration {

    public function up() {
        $datetime = date('Y-m-d H:i:s');
        DB::table('menus')->insert([
            [
                'id' => 1, 
                'header' => 'Página Inicial', 
                'controller' => 'default',
                'action' => 'index',
                'icon' => 'home',
                'parent' => '0',
                'order' => 1,
                'permissao_id' => null,
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => 2, 
                'header' => 'Configuração', 
                'controller' => 'parametros',
                'action' => '',
                'icon' => 'cogs',
                'parent' => '0',
                'order' => 2,
                'permissao_id' => 12,
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => 3, 
                'header' => 'Parâmetros', 
                'controller' => 'parametros',
                'action' => 'configurar',
                'icon' => 'sliders',
                'parent' => 2,
                'order' => 1,
                'permissao_id' => 19,
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => 4, 
                'header' => 'Anexos', 
                'controller' => 'anexos',
                'action' => 'index',
                'icon' => 'paperclip',
                'parent' => 2,
                'order' => 2,
                'permissao_id' => 19,
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => 5, 
                'header' => 'Usuários', 
                'controller' => 'users',
                'action' => 'index',
                'icon' => 'users',
                'parent' => 2,
                'order' => 3,
                'permissao_id' => 18,
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
            [
                'id' => 6, 
                'header' => 'Perfis', 
                'controller' => 'perfis',
                'action' => 'index',
                'icon' => 'user-secret',
                'parent' => 2,
                'order' => 4,
                'permissao_id' => 25,
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
        ]);
    }
}
