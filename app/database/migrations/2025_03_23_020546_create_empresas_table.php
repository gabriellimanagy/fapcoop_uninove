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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('fantasia')->nullable();
            $table->string('cnpj', 18)->unique();
            $table->string('insc_estadual', 50)->default('ISENTO');
            $table->string('endereco')->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->char('estado', 2)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('telefone1', 20)->nullable();
            $table->string('telefone2', 20)->nullable();
            $table->string('email')->nullable();
            $table->decimal('taxa_cheque', 10, 2)->default(0.00);
            $table->decimal('taxa_transf', 10, 2)->default(0.00);
            $table->decimal('taxa_pix', 10, 2)->default(0.00);
            $table->decimal('taxa_adm_cota', 10, 2)->default(0.00);
            $table->boolean('lancar_automaticamente')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
