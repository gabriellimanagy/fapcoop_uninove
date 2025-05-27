<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperado extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'dt_cadastro',
        'dt_ultima_escala',
        'nome',
        'sexo',
        'dt_desligamento',
        'status',
    ];

    // Definindo relacionamentos
    public function contato()
    {
        return $this->hasOne(CooperadoContato::class);
    }

    public function dadosPessoais()
    {
        return $this->hasOne(CooperadoPessoal::class);
    }

    public function documentos()
    {
        return $this->hasOne(CooperadoDocumento::class);
    }

    public function financeiro()
    {
        return $this->hasOne(Financeiro::class);
    }

    public function disponibilidade()
    {
        return $this->hasOne(Disponibilidade::class);
    }

    public function escalas()
    {
        return $this->belongsToMany(Escala::class, 'servicos', 'cooperado_id', 'escala_id')
                    ->withPivot('funcao_id', 'hr_entrada', 'hr_saida', 'hr_extra', 'dt_servico', 'dias_servico')
                    ->withTimestamps();
    }

    public function servicos()
    {
        return $this->hasMany(Servico::class);
    }
}
