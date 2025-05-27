<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperadoDocumento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cooperado_id', 'cpf', 'ccm', 'num_pis_inss', 'rg', 'dt_emissao', 'orgao_emissor', 'cidade_natal', 'dt_entrega_at_saude', 'carteira_trab', 'serie', 'titulo_eleitor', 'zona_eleitoral', 'num_cracha_carteirinha', 'cracha_cart_possui', 'antecedentes_criminais_dt_consulta', 'antecedentes_consultado_por', 'status'
    ];

    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class);
    }
}
