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
            $table->boolean('fechamento_de_escala')->default(false); // Default to false
            $table->boolean('pagamento')->default(false); // Default to false
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escalas', function (Blueprint $table) {
            $table->dropColumn('fechamento_de_escala');
            $table->dropColumn('pagamento');
        });
    }
};
