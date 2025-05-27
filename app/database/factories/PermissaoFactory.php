<?php

namespace Database\Factories;

use App\Models\Permissao;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissaoFactory extends Factory
{
    protected $model = Permissao::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->randomElement(['colaborador', 'administrador']),
            'departamento_id' => \App\Models\Departamento::factory(),
        ];
    }
}
