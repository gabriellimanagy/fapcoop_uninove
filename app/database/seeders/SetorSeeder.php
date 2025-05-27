<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente; // Importando o modelo Cliente corretamente
use App\Models\Setor;
use App\Models\Funcao;
use App\Models\Escala;
use App\Models\Servico;
use App\Models\User;
use App\Models\Cooperado;

class SetorSeeder extends Seeder
{
    public function run()
    {
        $clientes = Cliente::all();
        foreach ($clientes as $cliente) {
            Setor::factory(2)->create(['cliente_id' => $cliente->id]);
        }
    }
}
