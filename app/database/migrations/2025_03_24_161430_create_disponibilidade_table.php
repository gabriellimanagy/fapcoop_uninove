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
        Schema::create('disponibilidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cooperado_id')->constrained()->onDelete('cascade');
            $table->boolean('segunda_feira')->default(false);
            $table->boolean('terca_feira')->default(false);
            $table->boolean('quarta_feira')->default(false);
            $table->boolean('quinta_feira')->default(false);
            $table->boolean('sexta_feira')->default(false);
            $table->boolean('sabado')->default(false);
            $table->boolean('domingo')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilidade');
    }
};
