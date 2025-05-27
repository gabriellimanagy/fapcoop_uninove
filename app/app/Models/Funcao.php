<?php
// filepath: c:\Users\caiol\Desktop\Github\fapcoop\app\app\Models\Funcao.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;

    // Defina explicitamente o nome da tabela
    protected $table = 'funcoes';

    protected $fillable = [
        'nome', 'descricao', 'ativo'
    ];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_funcao')
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
