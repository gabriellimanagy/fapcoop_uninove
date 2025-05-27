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
        Schema::create('cooperado_contatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperado_id')->constrained()->onDelete('cascade');
            $table->string('celular');
            $table->boolean('whatsapp')->default(false);
            $table->string('telefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->string('email')->nullable();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('zona')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperado_contatos');
    }
};
