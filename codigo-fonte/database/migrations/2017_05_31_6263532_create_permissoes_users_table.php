<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissoesUsersTable extends Migration {

    public function up() {
        Schema::create('permissoes_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permissao_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permissao_id')->references('id')->on('permissoes');
        });
		
        DB::table('permissoes_users')->insert([
            [
                'id' => '1', 
                'permissao_id' => '1',
                'user_id' => '1',
            ],
            [
                'id' => '2', 
                'permissao_id' => '2',
                'user_id' => '1',
            ],
            [
                'id' => '3', 
                'permissao_id' => '3',
                'user_id' => '1',
            ],
        ]);
    }

    public function down() {
        Schema::drop('permissoes_users');
    }

}
