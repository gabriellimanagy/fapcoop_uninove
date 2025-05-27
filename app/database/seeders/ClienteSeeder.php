<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');

        foreach (range(1, 10) as $index) {
            Cliente::create([
                'razao_social' => $faker->company,
                'fantasia' => $faker->companySuffix,
                'documento' => $faker->cnpj,
                'identificacao' => strtoupper($faker->bothify('INS###')),
                'endereco' => $faker->streetAddress,
                'numero' => $faker->buildingNumber,
                'complemento' => $faker->secondaryAddress,
                'bairro' => $faker->citySuffix,
                'cidade' => $faker->city,
                'estado' => $faker->stateAbbr,
                'cep' => $faker->postcode,
                'telefone1' => $faker->phoneNumber,
                'telefone2' => $faker->optional()->phoneNumber,
                'email' => $faker->email,
                'pgto_ad_noturno' => $faker->randomFloat(2, 0, 10),
                'inss' => $faker->randomFloat(2, 0, 20),
                'aux_uniforme' => $faker->randomFloat(2, 0, 500),
                'vale_transporte' => $faker->randomFloat(2, 0, 500),
                'dt_cadastro' => $faker->date(),
                'exigir_antecedentes' => $faker->boolean,
            ]);
        }
    }
}
