<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Departamento;
use App\Models\Permissao;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
        ]);
        $this->call([
            ClienteProdSeeder::class,
        ]);
        $this->call([
            CooperadoSeeder::class,
        ]);
        //$this->call([
        //    ClienteSeeder::class,
        //]);

        //$this->call([
        //    FuncaoSeeder::class,
        //]);
        //$this->call([
        //    SetorSeeder::class,
        //]);
        //$this->call([
        //    EscalaSeeder::class,
        //]);
        //$this->call([
        //    ValeSeeder::class,
        //]);

        // Cria departamentos
        $departamentoAdministrador = Departamento::factory()->create(['nome' => 'Administrador']);
        $departamentoColaborador = Departamento::factory()->create(['nome' => 'Operacional']);
        $departamentoFinanceiro = Departamento::factory()->create(['nome' => 'Financeiro']);


        // Chama o seeder de empresas
        $this->call([
            EmpresaSeeder::class,
        ]);

        // Cria permissões
        $permissaoColaborador = Permissao::create(['nome' => 'colaborador']);
        $permissaoAdministrador = Permissao::create(['nome' => 'administrador']);


        // Cria usuário administrador
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@fapcoop.com',
            'password' => '123',
            'cpf' => '12345678901',
            'celular' => '12345678901',
            'departamento_id' => '1',
        ]);

        // Associa todas as permissões ao usuário administrador
        $todasPermissoes = Permissao::all();
        $admin->permissoes()->attach($todasPermissoes->pluck('id')->toArray());


    }
}
