<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CooperadoDocumento;
use App\Models\Cooperado;

class CooperadoDocumentoSeeder extends Seeder
{
    public function run()
    {
        Cooperado::all()->each(function ($cooperado) {
            $cooperado->documentos()->save(CooperadoDocumento::factory()->make());
        });
    }
}
