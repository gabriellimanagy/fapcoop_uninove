<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    use HasFactory;

    // Especificar o nome correto da tabela
    protected $table = 'financeiro';

    protected $fillable = [
        'cooperado_id',
        'descontar_inss',
        'descontar_ir',
        'receber_por',
        'banco_agencia',
        'banco_conta',
        'banco_tipo_conta',
        'pix_tipo_chave',
        'chave_pix',
    ];

    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class);
    }
}
