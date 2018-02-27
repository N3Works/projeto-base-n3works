<?php
use Illuminate\Database\Migrations\Migration;

class InsertParametroValoresTiposTable extends Migration {

    public function up() {
        DB::table('parametro_valores_tipos')->insert([
            [
                'id' => '1', 
                'value' => 'PADRAO',
                'header' => 'Padrão',
                'parametro_id' => 4,
            ],
            [
                'id' => '2', 
                'value' => 'PORTAL_GOLD',
                'header' => 'Portal Siconv - Gold',
                'parametro_id' => 4,
            ],
            [
                'id' => '3', 
                'value' => 'PORTAL_AZUL',
                'header' => 'Portal Siconv - Azul',
                'parametro_id' => 4,
            ],
            [
                'id' => '4', 
                'value' => '10',
                'header' => '10',
                'parametro_id' => 5,
            ],
            [
                'id' => '5', 
                'value' => '25',
                'header' => '25',
                'parametro_id' => 5,
            ],
            [
                'id' => '6', 
                'value' => '50',
                'header' => '50',
                'parametro_id' => 5,
            ],
            [
                'id' => '7', 
                'value' => '100',
                'header' => '100',
                'parametro_id' => 5,
            ],
        ]);
    }
}
