<?php
// filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\database\migrations\2025_03_25_000900_create_cliente_funcao_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Primeiro, verificamos se a tabela funcoes existe
        if (!Schema::hasTable('funcoes')) {
            // Criamos a tabela funcoes se não existir
            Schema::create('funcoes', function (Blueprint $table) {
                $table->id();
                $table->string('nome')->unique();
                $table->text('descricao')->nullable();
                $table->boolean('ativo')->default(true);
                $table->timestamps();
            });
        }

        // Agora criamos a tabela pivot
        Schema::create('cliente_funcao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            // Use a tabela correta aqui: 'funcoes' em vez de 'funcaos'
            $table->foreignId('funcao_id')->constrained('funcoes')->onDelete('cascade');
            $table->decimal('valor_hora_repasse', 10, 2)->default(0);
            $table->decimal('valor_hora_extra_repasse', 10, 2)->default(0);
            $table->decimal('valor_hora_faturamento', 10, 2)->default(0);
            $table->decimal('valor_hora_extra_faturamento', 10, 2)->default(0);
            $table->integer('qtd_horas_trabalhadas')->default(0);
            $table->timestamps();

            // Garantir que cada função só seja atribuída uma vez a cada cliente
            $table->unique(['cliente_id', 'funcao_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cliente_funcao');
        // Não devemos dropar a tabela 'funcoes' aqui, pois ela pode ser usada em outros lugares
    }
};
