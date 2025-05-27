<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permissao;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['nome' => 'funcionarios_btn_create'],
            ['nome' => 'funcionarios_btn_delete'],
            ['nome' => 'funcionarios_btn_edit'],
            ['nome' => 'empresa_cooperativa_menu_ativar'],
            ['nome' => 'empresa_empresa_excluir'],
            ['nome' => 'empresa_empresa_editar'],
            ['nome' => 'empresa_empresa_novo'],
            ['nome' => 'empresa_funcionarios_menu_ativar'],
            ['nome' => 'empresa_gerenciar_permissoes_menu_ativar'],
            ['nome' => 'cooperado_menu_ativar'],
            ['nome' => 'cooperado_btn_create'],
            ['nome' => 'cooperado_btn_edit'],
            ['nome' => 'cooperado_btn_delete'],
            ['nome' => 'clientes_menu_ativar'],
            ['nome' => 'cliente_btn_create'],
            ['nome' => 'cliente_btn_funcoes'],
            ['nome' => 'cliente_btn_delete'],
            ['nome' => 'cliente_btn_create_funcao'],
            ['nome' => 'cliente_btn_add_funcao'],
            ['nome' => 'cliente_btn_remove_funcao'],
            ['nome' => 'cliente_btn_create_setor'],
            ['nome' => 'cliente_btn_remove_setor'],
            ['nome' => 'escala_menu_ativar'],
            ['nome' => 'escala_btn_create_escala'],
            ['nome' => 'escala_btn_edit'],
            ['nome' => 'escala_btn_delete_escala'],
            ['nome' => 'escala_ver_total_faturamento'],
            ['nome' => 'escala_ver_total_repasse'],
            ['nome' => 'dashboard_ver_ativar'],
            ['nome' => 'escala_puxar_lista'],
            ['nome' => 'vales_menu_ativar'],
            ['nome' => 'baixar_escala_menu_ativar'],
            ['nome' => 'recibos_menu_ativar'],
            ['nome' => 'rlt_faturamento_menu_ativar'],

        ];

        foreach ($permissions as $permission) {
            Permissao::create($permission);
        }
    }
}
