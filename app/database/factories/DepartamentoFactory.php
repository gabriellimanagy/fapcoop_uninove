<?php

namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartamentoFactory extends Factory
{
    protected $model = Departamento::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->word,
        ];
    }
}
