<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValorTotalToServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicos', function (Blueprint $table) {
            if (!Schema::hasColumn('servicos', 'valor_total')) {
                $table->decimal('valor_total', 10, 2)->nullable()->after('dt_servico');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicos', function (Blueprint $table) {
            if (Schema::hasColumn('servicos', 'valor_total')) {
                $table->dropColumn('valor_total');
            }
        });
    }
}
