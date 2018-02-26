<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFakesTable extends Migration {
    
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up() {
        Schema::create('fakes', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('nome')->comment('Nome');
            $table->date('data')->comment('Data');
            $table->decimal('valor', 16, 2)->comment('Valor');
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