<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', // Adicionado explicitamente
        'escala_id',
        'cooperado_id',
        'funcao_id',
        'hr_entrada',
        'hr_saida',
        'hr_extra',
        'dt_servico',
        'valor_total',

        'dias_servico'
    ];

    /**
     * Get the escala that owns the service.
     */
    public function escala()
    {
        return $this->belongsTo(Escala::class);
    }

    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class);
    }

    /**
     * Get the function associated with the service.
     */
    public function funcao()
    {
        return $this->belongsTo(Funcao::class);
    }
}
