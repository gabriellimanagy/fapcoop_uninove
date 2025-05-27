<?php

namespace Database\Factories;

use App\Models\Funcao;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncaoFactory extends Factory
{
    protected $model = Funcao::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'ativo' => $this->faker->boolean(),
        ];
    }
}
