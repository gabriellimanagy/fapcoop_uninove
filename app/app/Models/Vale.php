<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vale extends Model
{
    use HasFactory;

    protected $fillable = [
        'cooperado_id',
        'valor',
        'descricao',
        'data_solicitacao',
        'data_desconto',
        'status'
    ];

    // Relacionamento com Cooperado
    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class);
    }
}
