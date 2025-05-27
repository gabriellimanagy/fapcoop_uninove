<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('escalas', function (Blueprint $table) {
            $table->dropColumn('setor'); // Remove a coluna antiga
            $table->foreignId('setor_id')->nullable()->constrained('setores')->onDelete('set null'); // Adiciona a chave estrangeira
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escalas', function (Blueprint $table) {
            $table->string('setor'); // Reverte para a coluna antiga
            $table->dropForeign(['setor_id']);
            $table->dropColumn('setor_id');
        });
    }
};
