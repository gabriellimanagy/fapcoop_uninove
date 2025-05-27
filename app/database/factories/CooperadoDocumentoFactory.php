<?php

namespace Database\Factories;

use App\Models\CooperadoDocumento;
use Illuminate\Database\Eloquent\Factories\Factory;

class CooperadoDocumentoFactory extends Factory
{
    protected $model = CooperadoDocumento::class;

    public function definition()
    {
        return [
            'cpf' => $this->faker->numerify('###########'), // 11 dígitos
            'ccm' => $this->faker->numberBetween(100000, 999999), // 6 dígitos
            'num_pis_inss' => $this->faker->numerify('############'), // 12 dígitos
            'rg' => $this->faker->numerify('#########'), // 9 dígitos
            'dt_emissao' => $this->faker->date(),
            'orgao_emissor' => $this->faker->randomElement(['SSP', 'DETRAN', 'PM', 'OAB']),
            'cidade_natal' => $this->faker->city(),
            'dt_entrega_at_saude' => $this->faker->optional()->date(),
            'carteira_trab' => $this->faker->numerify('##########'), // 10 dígitos
            'serie' => $this->faker->numberBetween(1000, 9999), // 4 dígitos
            'titulo_eleitor' => $this->faker->numerify('###########'), // 11 dígitos
            'zona_eleitoral' => $this->faker->numberBetween(1, 999), // Número pequeno
            'num_cracha_carteirinha' => $this->faker->numerify('########'), // 8 dígitos
            'cracha_cart_possui' => $this->faker->boolean(),
            'antecedentes_criminais_dt_consulta' => $this->faker->optional()->date(),
            'antecedentes_consultado_por' => $this->faker->name(),
            'status' => $this->faker->randomElement(['Regular', 'Irregular']),
        ];
    }
}
