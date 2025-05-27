<?php

namespace Database\Factories;

use App\Models\Servico;
use App\Models\Escala;
use App\Models\Cooperado;
use App\Models\Funcao;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicoFactory extends Factory
{
    protected $model = Servico::class;

    public function definition()
    {
        $cooperados = Cooperado::all(); // Carrega todos os cooperados
        $escalaId = Escala::inRandomOrder()->first()->id; // Pega uma escala aleatória
        $funcaoId = Funcao::inRandomOrder()->first()->id; // Pega uma função aleatória
        
        // Verifica se existem cooperados suficientes para a quantidade de escalas
        if ($cooperados->isEmpty()) {
            throw new \Exception('Não há cooperados cadastrados para vincular aos serviços.');
        }

        // Se necessário, embaralha e escolhe um cooperado aleatório da lista
        $cooperadoId = $cooperados->random()->id;

        return [
            'escala_id' => $escalaId,
            'cooperado_id' => $cooperadoId,
            'funcao_id' => $funcaoId,
            'hr_entrada' => '08:00:00',
            'hr_saida' => '17:00:00',
            'hr_extra' => '01:00:00',
            'dt_servico' => now()->addDays(7),
            'dias_servico' => 1,
        ];
    }
}

