<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscalasTable extends Migration
{
    public function up()
    {
        Schema::create('escalas', function (Blueprint $table) {
            $table->id(); // This is already a proper primary key
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('setor');
            $table->string('nome_evento')->nullable();
            $table->date('data_solicitacao');
            $table->date('data_servico');
            $table->date('data_inicio_servico');
            $table->text('observacoes')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('status')->default('ativa');
            $table->string('lote')->default('-');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escalas');
    }
}
