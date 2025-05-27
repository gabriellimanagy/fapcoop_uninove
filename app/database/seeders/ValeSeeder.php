<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vale;

class ValeSeeder extends Seeder
{
    public function run(): void
    {
        // Gera 20 vales fictícios
        Vale::factory()->count(20)->create();
    }
}
