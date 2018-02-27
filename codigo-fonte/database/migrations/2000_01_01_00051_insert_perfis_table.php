<?php
use Illuminate\Database\Migrations\Migration;

class InsertPerfisTable extends Migration {

    public function up() {
        DB::table('perfis')->insert([
            [
                'id' => 1, 
                'nome' => 'Administrador',
            ],
            [
                'id' => 2, 
                'nome' => 'Padrão',
            ],
        ]);
    }
}

