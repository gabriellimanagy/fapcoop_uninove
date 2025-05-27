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
        Schema::create('vales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperado_id')->constrained()->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->string('descricao');
            $table->date('data_solicitacao');
            $table->date('data_desconto');
            $table->enum('status', ['pendente', 'aprovado', 'negado'])->default('pendente');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vales');
    }
};
