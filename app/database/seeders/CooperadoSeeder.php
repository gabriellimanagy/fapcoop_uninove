<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cooperado;
use App\Models\CooperadoContato;
use App\Models\CooperadoDocumento;
use App\Models\CooperadoPessoal;

class CooperadoSeeder extends Seeder
{
    public function run()
    {
        Cooperado::factory(100)->create()->each(function ($cooperado) {
            $cooperado->contato()->save(CooperadoContato::factory()->make());
            $cooperado->documentos()->save(CooperadoDocumento::factory()->make());
            $cooperado->dadosPessoais()->save(CooperadoPessoal::factory()->make());
        });
    }
}
