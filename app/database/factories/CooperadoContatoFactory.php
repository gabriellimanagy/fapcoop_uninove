<?php

namespace Database\Factories;

use App\Models\CooperadoContato;
use Illuminate\Database\Eloquent\Factories\Factory;

class CooperadoContatoFactory extends Factory
{
    protected $model = CooperadoContato::class;

    public function definition()
    {
        return [
            'celular' => $this->faker->phoneNumber(),
            'whatsapp' => $this->faker->boolean(),
            'telefone1' => $this->faker->optional()->phoneNumber(),
            'telefone2' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'cep' => $this->faker->postcode(),
            'endereco' => $this->faker->address(),
            'zona' => $this->faker->randomElement(['Urbana', 'Rural']),
            'bairro' => $this->faker->streetName(),
            'cidade' => $this->faker->city(),
            'uf' => $this->faker->stateAbbr(),
        ];
    }
}
