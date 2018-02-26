<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
    
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('nome')->comment('Nome');
            $table->string('cpf', 11)->comment('CPF');
            $table->string('email')->unique()->comment('E-mail');
            $table->string('password')->nullable()->comment('Senha');
            $table->rememberToken();
            $table->timestamps();
        });

        $datetime = date('Y-m-d H:i:s');
        DB::table('users')->insert([
            [
                'id' => '1', 
                'cpf' => '03044565006', 
                'nome' => 'Administrador',
                'email' => 'fake@fake.com',
                'password' => '202cb962ac59075b964b07152d234b70',
                'created_at' => $datetime,
                'updated_at' => $datetime, 
            ],
        ]);
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down() {
        Schema::drop('users');
    }
}