<?php

namespace Database\Factories;

use App\Models\Cooperado;
use Illuminate\Database\Eloquent\Factories\Factory;

class CooperadoFactory extends Factory
{
    protected $model = Cooperado::class;

    public function definition()
    {
        return [
            'matricula' => $this->faker->unique()->randomNumber(5),
            'dt_cadastro' => $this->faker->date(),
            'dt_ultima_escala' => $this->faker->optional()->date(),
            'nome' => $this->faker->name(),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'dt_desligamento' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(['Ativo', 'Inativo']),
        ];
    }
}
