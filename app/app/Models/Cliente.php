<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome','razao_social', 'fantasia', 'documento', 'identificacao', 'endereco',
        'numero', 'complemento', 'bairro', 'cidade', 'estado', 'cep',
        'telefone1', 'telefone2', 'email', 'pgto_ad_noturno', 'inss',
        'aux_uniforme', 'vale_transporte', 'dt_cadastro', 'exigir_antecedentes'
    ];

    /**
     * Relacionamento com Setor.
     * Um cliente pode ter muitos setores.
     */
    public function setores()
    {
        return $this->hasMany(Setor::class, 'cliente_id', 'id');
    }

    /**
     * Relacionamento com Função.
     * Um cliente pode ter muitas funções.
     */

    public function funcoes()
    {
        return $this->belongsToMany(Funcao::class, 'cliente_funcao')
                    ->withPivot([
                        'valor_hora_repasse',
                        'valor_hora_extra_repasse',
                        'valor_hora_faturamento',
                        'valor_hora_extra_faturamento',
                        'qtd_horas_trabalhadas'
                    ])
                    ->withTimestamps();
    }
}
