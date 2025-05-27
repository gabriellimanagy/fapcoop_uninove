<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CooperadoPessoal;
use App\Models\Cooperado;

class CooperadoPessoalSeeder extends Seeder
{
    public function run()
    {
        Cooperado::all()->each(function ($cooperado) {
            $cooperado->dadosPessoais()->save(CooperadoPessoal::factory()->make());
        });
    }
}
