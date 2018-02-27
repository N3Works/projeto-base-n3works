<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfisTable extends Migration {

    public function up() {
        Schema::create('perfis', function (Blueprint $table) {
            $table->increments("id");
            $table->string("nome", 255);
        });
    }

    public function down() {
        Schema::drop('perfis');
    }

}
