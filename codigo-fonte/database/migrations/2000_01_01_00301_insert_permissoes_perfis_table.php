<?php
use Illuminate\Database\Migrations\Migration;

class InsertPermissoesPerfisTable extends Migration {

    public function up() {
        DB::table('permissoes_perfis')->insert([
            ['permissao_id' => '1', 'perfil_id' => '1'],
            ['permissao_id' => '2', 'perfil_id' => '1'],
            ['permissao_id' => '3', 'perfil_id' => '1'],
            ['permissao_id' => '4', 'perfil_id' => '1'],
            ['permissao_id' => '5', 'perfil_id' => '1'],
            ['permissao_id' => '6', 'perfil_id' => '1'],
            ['permissao_id' => '7', 'perfil_id' => '1'],
            ['permissao_id' => '8', 'perfil_id' => '1'],
            ['permissao_id' => '9', 'perfil_id' => '1'],
            ['permissao_id' => '10', 'perfil_id' => '1'],
            ['permissao_id' => '11', 'perfil_id' => '1'],
            ['permissao_id' => '12', 'perfil_id' => '1'],
            ['permissao_id' => '13', 'perfil_id' => '1'],
            ['permissao_id' => '14', 'perfil_id' => '1'],
            ['permissao_id' => '15', 'perfil_id' => '1'],
            ['permissao_id' => '16', 'perfil_id' => '1'],
            ['permissao_id' => '17', 'perfil_id' => '1'],
            ['permissao_id' => '18', 'perfil_id' => '1'],
            ['permissao_id' => '19', 'perfil_id' => '1'],
            ['permissao_id' => '20', 'perfil_id' => '1'],
            ['permissao_id' => '21', 'perfil_id' => '1'],
            ['permissao_id' => '22', 'perfil_id' => '1'],
            ['permissao_id' => '23', 'perfil_id' => '1'],
            ['permissao_id' => '24', 'perfil_id' => '1'],
            ['permissao_id' => '25', 'perfil_id' => '1'],
        ]);
    }
}
