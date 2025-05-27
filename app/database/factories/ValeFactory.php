<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vale;
use App\Models\Cooperado;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vale>
 */
class ValeFactory extends Factory
{
    protected $model = Vale::class;

    public function definition(): array
    {
        return [
            'cooperado_id' => Cooperado::inRandomOrder()->first()->id ?? Cooperado::factory(),
            'status' => $this->faker->randomElement(['pendente', 'aprovado', 'negado']),
            'valor' => $this->faker->randomFloat(2, 50, 1000),
            'descricao' => $this->faker->sentence(),
            'data_solicitacao' => $this->faker->date(),
            'data_desconto' => $this->faker->date()
        ];
    }
}
