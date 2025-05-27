<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissoesSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissoes')->insert([ // Correção: nome da tabela correto
            'nome' => 'colaborador',
            'departamento_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
