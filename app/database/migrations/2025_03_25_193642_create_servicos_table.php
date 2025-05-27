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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escala_id')->constrained('escalas'); // Changed from id_escala to escala_id and references id in escalas
            $table->foreignId('cooperado_id')->constrained('cooperados');
            $table->foreignId('funcao_id')->nullable()->constrained('funcoes');
            $table->time('hr_entrada')->nullable();
            $table->time('hr_saida')->nullable();
            $table->time('hr_extra')->nullable();
            $table->date('dt_servico')->nullable();
            $table->integer('dias_servico')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('servicos');
    }
};
