<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperadoPessoal extends Model
{
    use HasFactory;

    // Especificar o nome correto da tabela
    protected $table = 'cooperado_pessoais';

    protected $fillable = [
        'cooperado_id',
        'dt_nascimento',
        'nacionalidade',
        'nome_mae',
        'nome_pai',
        'est_civil',
        'escolaridade',
        'qualificacao',
        'qualificacao_justificativa',
        'indicado_por',
    ];

    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class);
    }
}
