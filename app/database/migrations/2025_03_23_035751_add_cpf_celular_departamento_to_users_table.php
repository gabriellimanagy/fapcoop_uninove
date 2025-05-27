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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->unique()->after('email');
            $table->string('celular')->after('cpf');
            $table->foreignId('departamento_id')->nullable()->constrained()->after('celular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cpf');
            $table->dropColumn('celular');
            $table->dropForeign(['departamento_id']);
            $table->dropColumn('departamento_id');
        });
    }
};
