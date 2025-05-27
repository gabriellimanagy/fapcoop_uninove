<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilidade extends Model
{
    use HasFactory;

    // Especificar o nome correto da tabela
    protected $table = 'disponibilidade';

    protected $fillable = [
        'cooperado_id',
        'segunda_feira',
        'terca_feira',
        'quarta_feira',
        'quinta_feira',
        'sexta_feira',
        'sabado',
        'domingo',
    ];

    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class);
    }
}
