<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Remover a coluna departamento_id da tabela permissoes
        Schema::table('permissoes', function (Blueprint $table) {
            $table->dropForeign(['departamento_id']);
            $table->dropColumn('departamento_id');
        });

        // Criar a tabela pivot departamento_permissao
        Schema::create('departamento_permissao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained()->onDelete('cascade');
            $table->foreignId('permissao_id')->constrained('permissoes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Reverter as alterações
        Schema::dropIfExists('departamento_permissao');

        Schema::table('permissoes', function (Blueprint $table) {
            $table->foreignId('departamento_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};
