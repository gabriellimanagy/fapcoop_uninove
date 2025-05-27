<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria empresas de exemplo
        Empresa::create([
            'razao_social' => 'FAP COOPERATIVA DE TRABALHADORES AUTONOMOS ',
            'fantasia' => 'COOPER JOBS',
            'cnpj' => '39892437000112',
            'email' => 'financeiro@fapcoop.com',
            'telefone1' => '1129893909',
            'telefone2' => '11945480720',
            'endereco' => 'AV. ÁLVARO MACHADO PEDROSA',
            'numero' => '442',
            'complemento' => 'ALTOS',
            'bairro' => 'PARADA INGLESA',
            'insc_estadual' => 'ISENTO',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '02245000',
        ]);

    }
}
