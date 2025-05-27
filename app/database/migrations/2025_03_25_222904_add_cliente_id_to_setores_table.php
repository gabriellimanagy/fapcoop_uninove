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
        Schema::table('setores', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente_id')->after('nome'); // Adiciona a coluna cliente_id
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade'); // Define a chave estrangeira
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('setores', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
        });
    }
};
