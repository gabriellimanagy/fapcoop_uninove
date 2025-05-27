<?php
// database/migrations/xxxx_xx_xx_create_funcoes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('funcoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcoes');
    }
};
