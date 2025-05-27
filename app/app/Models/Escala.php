<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'setor_id',
        'nome_evento',
        'data_solicitacao',
        'data_servico',
        'data_inicio_servico',
        'observacoes',
        'user_id',
        'status',
        'fechamento_de_escala',
        'pagamento',
        'lote',
    ];

    /**
     * Get the client associated with the escala.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function setor()
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }
    /**
     * Get the user who created the escala.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the cooperados for the escala.
     */
    public function cooperados()
    {
        return $this->belongsToMany(Cooperado::class, 'servicos', 'escala_id', 'cooperado_id')
                    ->withPivot('funcao_id', 'hr_entrada', 'hr_saida', 'hr_extra', 'dt_servico', 'dias_servico')
                    ->withTimestamps();
    }

    /**
     * Get all of the services for the escala.
     */
    // App/Models/Escala.php
public function servicos()
{
    return $this->hasMany(Servico::class);
}
}
