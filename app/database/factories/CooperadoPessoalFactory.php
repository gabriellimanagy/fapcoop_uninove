<?php

namespace Database\Factories;

use App\Models\CooperadoPessoal;
use Illuminate\Database\Eloquent\Factories\Factory;

class CooperadoPessoalFactory extends Factory
{
    protected $model = CooperadoPessoal::class;

    public function definition()
    {
        return [
            'dt_nascimento' => $this->faker->date(),
            'nacionalidade' => $this->faker->country(),
            'nome_mae' => $this->faker->name('female'),
            'nome_pai' => $this->faker->name('male'),
            'est_civil' => $this->faker->randomElement(['Solteiro', 'Casado', 'Divorciado']),
            'escolaridade' => $this->faker->randomElement(['Fundamental', 'Médio', 'Superior']),
            'qualificacao' => $this->faker->numberBetween(1, 10), 
            'qualificacao_justificativa' => $this->faker->optional()->sentence(),
            'indicado_por' => $this->faker->optional()->name(),
        ];
    }
}
