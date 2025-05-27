<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteProdSeeder extends Seeder
{
    public function run()
    {
        Cliente::create([
            'razao_social' => 'CLUBE ATLETICO MONTE LIBANO',
            'fantasia' => 'MONTE LIBANO',
            'documento' => '60.782.778/0001-21',
            'identificacao' => null, // No value provided in the screenshot
            'endereco' => 'AV. REPUBLICA DO LIBANO',
            'numero' => '2267',
            'complemento' => null, // No value provided in the screenshot
            'bairro' => 'MOEMA',
            'cidade' => 'SAO PAULO',
            'estado' => 'SP',
            'cep' => '04502-904',
            'telefone1' => '(11)5088-7060',
            'telefone2' => '(11)5088-7034',
            'email' => 'contato@caml.com.br',
            'pgto_ad_noturno' => 0.0000,
            'inss' => 0.0000,
            'aux_uniforme' => 0.00,
            'vale_transporte' => 0.00,
            'dt_cadastro' => '2022-02-21',
            'exigir_antecedentes' => false,
        ]);

        Cliente::create([
            'razao_social' => 'ASSOCIACAO ATLÉTICA BANCO DO BRASIL',
            'fantasia' => 'AABB',
            'documento' => '33.456.789/0001-10',
            'identificacao' => null, // No value provided
            'endereco' => 'RUA DOS BANCÁRIOS',
            'numero' => '1234',
            'complemento' => 'PRÓXIMO AO PARQUE',
            'bairro' => 'JARDIM FINANCEIRO',
            'cidade' => 'BRASÍLIA',
            'estado' => 'DF',
            'cep' => '70000-000',
            'telefone1' => '(61)4000-1234',
            'telefone2' => '(61)4000-5678',
            'email' => 'contato@aabb.com.br',
            'pgto_ad_noturno' => 0.0000,
            'inss' => 0.0000,
            'aux_uniforme' => 0.00,
            'vale_transporte' => 0.00,
            'dt_cadastro' => '2023-01-15',
            'exigir_antecedentes' => true,
        ]);
    }
}
