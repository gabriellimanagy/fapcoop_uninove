<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cooperado_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperado_id')->constrained()->onDelete('cascade');
            $table->string('cpf')->nullable();
            $table->string('ccm')->nullable();
            $table->string('num_pis_inss')->nullable();
            $table->string('rg')->nullable();
            $table->date('dt_emissao')->nullable();
            $table->string('orgao_emissor')->nullable();
            $table->string('cidade_natal')->nullable();
            $table->date('dt_entrega_at_saude')->nullable();
            $table->string('carteira_trab')->nullable();
            $table->string('serie')->nullable();
            $table->string('titulo_eleitor')->nullable();
            $table->string('zona_eleitoral')->nullable();
            $table->string('num_cracha_carteirinha')->nullable();
            $table->boolean('cracha_cart_possui')->default(false);
            $table->date('antecedentes_criminais_dt_consulta')->nullable();
            $table->string('antecedentes_consultado_por')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperado_documentos');
    }
};
