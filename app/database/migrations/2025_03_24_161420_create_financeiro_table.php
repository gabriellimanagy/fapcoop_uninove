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
        Schema::create('financeiro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperado_id')->constrained()->onDelete('cascade');
            $table->boolean('descontar_inss')->default(false);
            $table->boolean('descontar_ir')->default(false);
            $table->string('receber_por')->nullable();
            $table->string('banco_agencia')->nullable();
            $table->string('banco_conta')->nullable();
            $table->string('banco_tipo_conta')->nullable();
            $table->string('pix_tipo_chave')->nullable();
            $table->string('chave_pix')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financeiro');
    }
};
