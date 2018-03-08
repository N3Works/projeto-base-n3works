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
            $table->string('cpf', 14)->comment('CPF');
            $table->string('email')->unique()->comment('E-mail');
            $table->string('password')->nullable()->comment('Senha');
            $table->integer("perfil_id")->unsigned();
            $table->foreign('perfil_id')->references('id')->on('perfis');
            $table->rememberToken();
            $table->timestamps();
        });
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