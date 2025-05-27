<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente; // Importando o modelo Cliente corretamente
use App\Models\Setor;
use App\Models\Funcao;
use App\Models\Escala;
use App\Models\Servico;
use App\Models\User;
use App\Models\Cooperado;


class ServicoSeeder extends Seeder
{
    public function run()
    {
        $escalas = Escala::all();
        $cooperados = Cooperado::all();
        $funcoes = Funcao::all();

        foreach ($escalas as $escala) {
            foreach ($cooperados as $cooperado) {
                Servico::factory()->create([
                    'escala_id' => $escala->id,
                    'cooperado_id' => $cooperado->id,
                    'funcao_id' => $funcoes->random()->id,
                    'hr_entrada' => '08:00:00',
                    'hr_saida' => '17:00:00',
                    'hr_extra' => '01:00:00',
                    'dt_servico' => Carbon::now()->addDays(7),
                    'dias_servico' => rand(1, 5),
                ]);
            }
        }
    }
}
