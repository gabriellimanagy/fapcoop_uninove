<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funcao;

class FuncaoSeeder extends Seeder
{
    public function run()
    {
        Funcao::factory(5)->create(); // Cria 5 funções de exemplo
    }
}
