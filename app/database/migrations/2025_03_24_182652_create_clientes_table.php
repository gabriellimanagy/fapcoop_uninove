<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social');
            $table->string('fantasia')->nullable();
            $table->string('cnpj', 18)->unique();
            $table->string('insc_estadual')->nullable();
            $table->string('endereco');
            $table->string('numero', 10);
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 9);
            $table->string('telefone1', 15);
            $table->string('telefone2', 15)->nullable();
            $table->string('email')->unique();
            $table->decimal('pgto_ad_noturno', 8, 4)->default(0);
            $table->decimal('inss', 8, 4)->default(0);
            $table->decimal('aux_uniforme', 10, 2)->default(0);
            $table->decimal('vale_transporte', 10, 2)->default(0);
            $table->date('dt_cadastro')->default(now());
            $table->boolean('exigir_antecedentes')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
