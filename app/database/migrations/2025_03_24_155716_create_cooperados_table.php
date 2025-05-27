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
        Schema::create('cooperados', function (Blueprint $table) {
            $table->id();
            $table->string('matricula')->unique();
            $table->date('dt_cadastro');
            $table->date('dt_ultima_escala')->nullable();
            $table->string('nome');
            $table->enum('sexo', ['M', 'F']);
            $table->date('dt_desligamento')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperados');
    }
};
