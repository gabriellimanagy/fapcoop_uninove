<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('clientes', function (Blueprint $table) {
            $table->renameColumn('cnpj', 'documento'); // Renomeia CNPJ para Documento
            $table->renameColumn('insc_estadual', 'identificacao'); // Renomeia Insc. Estadual para Identificação
            $table->string('documento', 18)->change(); // Garante que aceita CPF (11) e CNPJ (14)
            $table->string('identificacao')->nullable()->change(); // Aceita RG ou Inscrição Estadual
        });
    }

    public function down() {
        Schema::table('clientes', function (Blueprint $table) {
            $table->renameColumn('documento', 'cnpj');
            $table->renameColumn('identificacao', 'insc_estadual');
        });
    }
};
