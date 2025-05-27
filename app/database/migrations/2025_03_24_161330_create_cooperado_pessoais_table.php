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
        Schema::create('cooperado_pessoais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperado_id')->constrained()->onDelete('cascade');
            $table->date('dt_nascimento')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('est_civil')->nullable();
            $table->string('escolaridade')->nullable();
            $table->integer('qualificacao')->nullable();
            $table->text('qualificacao_justificativa')->nullable();
            $table->string('indicado_por')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperado_pessoais');
    }
};
