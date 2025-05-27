<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CooperadoContato;
use App\Models\Cooperado;

class CooperadoContatoSeeder extends Seeder
{
    public function run()
    {
        Cooperado::all()->each(function ($cooperado) {
            $cooperado->contato()->save(CooperadoContato::factory()->make());
        });
    }
}
