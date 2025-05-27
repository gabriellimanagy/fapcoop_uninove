<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;

    // Defina explicitamente o nome da tabela
    protected $table = 'setores';

    protected $fillable = ['nome', 'cliente_id'];

    /**
     * Relacionamento com Cliente.
     * Um setor pertence a um cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
    public function escalas()
    {
        return $this->hasMany(Escala::class, 'setor_id');
    }
}
