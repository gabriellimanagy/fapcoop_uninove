<?php

namespace Database\Factories;

use App\Models\Setor;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class SetorFactory extends Factory
{
    protected $model = Setor::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::inRandomOrder()->first()->id, // Associa um cliente aleatório
            'nome' => $this->faker->word(),
        ];
    }
}
